<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\BaseApplication;
use App\Models\Player;
use App\Models\CategoryQuiz;
use App\Models\Question;
use App\Models\Withdrawal;
use App\Models\Daget;
use App\Models\PaymentMethod;
use App\Models\HistoryQuiz;
use App\Models\RefferalPlayer;
use App\Models\Avatar;
use App\Models\Device;
use App\Models\QuizCompleted;
use App\Models\HistoryCollectedPoint;
use App\Models\HistoryCollectedRewardsAdPoint;
use App\Models\HistoryExchangeBadgePlayer;
use App\Models\Banner;
use App\Models\Badge;
use App\Models\RewardsAdPoints;
use App\Models\WatchListPlayer;
use App\Models\CompletedArticlePoint;
use App\Models\CompletedPointKaget;
use App\Models\AdsCounterTemporary;

use App\Helper\ApiFormatter;
use App\Helper\ApiFormatterV2;

use Carbon\Carbon;

class ApiControllerV3 extends Controller
{
    public static function initializeMainApplication(Request $request)
    {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = "TEST";
        $head_device_name = "TEST";

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $playerIsLogin = null;

        if (is_null($head_app_pkg) || is_null($head_app_id) || is_null($head_app_code) || is_null($head_app_access_key)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $mCekBaseApplicationNewVersion = BaseApplication::where('id', $head_app_id)->where('app_pkg', $head_app_pkg)->where('app_access_key', $head_app_access_key)->first();

        if (!is_null($mCekBaseApplicationNewVersion)) {
            if ($mCekBaseApplicationNewVersion->app_is_redirect == 1) {
                return ApiFormatter::createApiRedirectApp($mCekBaseApplicationNewVersion->app_url_redirect);
            }
            if ($head_app_code < $mCekBaseApplicationNewVersion->app_code) {
                return ApiFormatter::createApiUpdateApp();
            }
            if ($mCekBaseApplicationNewVersion->app_is_maintanance == 1) {
                return ApiFormatter::createApiMaintanance($mCekBaseApplicationNewVersion->app_msg_maintanance);
            }
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)->where('app_pkg', $head_app_pkg)->where('app_access_key', $head_app_access_key)->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('ACCESS MAIN APPLICATION DENIED');
        }

        if ($mBaseApplication->settings_validation_device_api == 1) {
            $head_device_id = $request->header('device_id');
            $head_device_name = $request->header('device_name');
        }

        $mainAppDagetList = $mBaseApplication->dana_kaget;
        $mainAppCategoryQuizList = $mBaseApplication->category_quiz;
        $mainAppBannerList = $mBaseApplication->banner;
        $mainAppRewardAdPointList = $mBaseApplication->rewards_ad_points;
        $mainAppBadgeList = $mBaseApplication->badge;

        $paymentMethodList = PaymentMethod::orderBy("created_at", "asc")->get();

        $mDagetList = Daget::orderBy("created_at", "asc")->get();
        $mBannerList = Banner::orderBy("created_at", "asc")->get();
        $mRewardsAdPointsList = RewardsAdPoints::orderBy("created_at", "asc")->get();
        $mCategoryQuizList = CategoryQuiz::all();
        $mBadgeList = Badge::where('badge_level', '!=', 1)->get();

        $dagetList = [];
        $categoryQuizList = [];
        $bannerList = [];
        $rewardsAdPointList = [];
        $badgeList = [];

        foreach ($mDagetList as $daget) {
            $daget->makeHidden(['claimed']);
            $daget->makeHidden(['info_rupiah']);
            $encrypted = base64_encode($daget->url);
            $daget->url = $encrypted;
            foreach ($mainAppDagetList as $dagetID) {
                if ($dagetID == $daget->id) {
                    $dagetList[] = $daget;
                }
            }
        }

        foreach ($mCategoryQuizList as $categoryQuiz) {
            foreach ($mainAppCategoryQuizList as $categoryQuizID) {
                if ($categoryQuizID == $categoryQuiz->id) {
                    $categoryQuizList[] = $categoryQuiz;
                }
            }
        }

        foreach ($mBannerList as $banner) {
            foreach ($mainAppBannerList as $bannerID) {
                if ($bannerID == $banner->id) {
                    $bannerList[] = $banner;
                }
            }
        }

        foreach ($mRewardsAdPointsList as $mRewardsAdPointsData) {
            foreach ($mainAppRewardAdPointList as $rewardsAdPointId) {
                if ($rewardsAdPointId == $mRewardsAdPointsData->id) {
                    $rewardsAdPointList[] = $mRewardsAdPointsData;
                }
            }
        }

        foreach ($mBadgeList as $mBadgeData) {
            foreach ($mainAppBadgeList as $mainAppBadgeListID) {
                if ($mainAppBadgeListID == $mBadgeData->id) {
                    $badgeList[] = $mBadgeData;
                }
            }
        }

        if (!is_null($playerLoginId)) {
            $playerIsLogin = Player::where('id', $playerLoginId)->where('player_pkg', $head_app_pkg)->first();
        }

        if (!is_null($playerLoginToken) && !is_null($playerLoginId)) {
            $playerIsLoginToken = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->first();
            if (is_null($playerIsLoginToken)) {
                return ApiFormatter::createApiLoginRetry();
            }
        }

        $totalWithdralAppAmount = Withdrawal::where('player_pkg', $mBaseApplication->app_pkg)->where('status', '1')->sum('amount');

        $lastWithdrawalAcceptable = Withdrawal::select('withdrawals.*', 'players.name')
        ->join('players', 'withdrawals.player_id', '=', 'players.id')
        ->where('withdrawals.player_pkg', $mBaseApplication->app_pkg)
        ->where('withdrawals.status', '1')
        ->orderBy('updated_at', 'desc')
        ->limit(20)
        ->get();

        $completedQuizList = [];

        $avatarList = Avatar::all();
        $badgeOnPlayerList = null;
        $badgesOnPlayerPrimary = null;

        if (!is_null($playerIsLogin)) {
            if ($mBaseApplication->settings_date_all_completed == 1) {
                $completedQuizList = QuizCompleted::where('player_id', $playerIsLogin->id)
                ->where('player_pkg', $playerIsLogin->player_pkg)
                ->whereDate('created_at', Carbon::now())
                ->get();
            } else {
                $completedQuizList = QuizCompleted::where('player_id', $playerIsLogin->id)
                ->where('player_pkg', $playerIsLogin->player_pkg)
                ->get();
            }

            $badgesOnPlayer = HistoryExchangeBadgePlayer::where('player_id', $playerIsLogin->id)
            ->get();
            $badgeCounts = $badgesOnPlayer->groupBy('badge_id')->map(function ($group) {
                return $group->count();
            });
            $badgeIds = $badgeCounts->keys();
            $badgeOnPlayerList = Badge::whereIn('id', $badgeIds)->get()->map(function ($badge) use ($badgeCounts) {
                $badge->count = $badgeCounts[$badge->id];
                return $badge;
            });

            $badgeIdsPrimary = $playerIsLogin->badge_primary;
            $badgesOnPlayerPrimary = Badge::where('id', $badgeIdsPrimary)
            ->first();

            $primaryBadge = Badge::where('id', $playerIsLogin->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $playerIsLogin->badge_primary_name = $primaryBadge->badge_name;
            $playerIsLogin->badge_primary_icon = $primaryBadge->badge_icon;
            
        } 

        return ApiFormatter::createApiSuccess('Data fetched', [
            'MainApplication' => $mBaseApplication,
            'MainDagetList' => $dagetList,
            'MainCategoryQuizList' => $categoryQuizList,
            'MainBannerList' => $bannerList,
            'MainRewardsAdPointList' => $rewardsAdPointList,
            'PaymentMethodList' => $paymentMethodList,
            'TotalWithdrawal' => $totalWithdralAppAmount,
            'LastWithdrawalPlayer' => $lastWithdrawalAcceptable,
            'AvatarList' => $avatarList,
            'BadgeList' => $badgeList,
            'BadgeOnPlayerList' => $badgeOnPlayerList,
            'BadgeOnPlayerPrimary' => $badgesOnPlayerPrimary,
            'PlayerData' => $playerIsLogin,
            'CompletedQuiz' => $completedQuizList
        ]);
    }

    // END INIT APPLICATION

    public static function loginPlayer(Request $request)
    {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');
        $head_is_main_application = $request->header('is_main_application');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_is_main_application) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $data_player_email = $request->player_email;
        $data_player_password = $request->player_password;

        if (is_null($data_player_email) || is_null($data_player_password)) {
            return ApiFormatter::createApiFailed('Harap lengkapi data login');
        }

        if (!filter_var($data_player_email, FILTER_VALIDATE_EMAIL)) {
            return ApiFormatter::createApiFailed('Harap masukan email valid');
        }

        $cekPlayerExists = Player::where('email', $data_player_email)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Pengguna tidak ditemukan');
        }

        $newTokenPlayer = Str::random(100, 'alpha_num_or_symbols');
        $deviceList = Device::all();

        if ($head_is_main_application == 1) {
            $mBaseApplication = BaseApplication::where('id', $head_app_id)->where('app_pkg', $head_app_pkg)->where('app_access_key', $head_app_access_key)->first();
            if (is_null($mBaseApplication)) {
                 return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
            }

            if ($mBaseApplication->app_pkg != $cekPlayerExists->player_pkg) {
                return ApiFormatter::createApiFailed('Pengguna tidak ditemukan');
            }

            if (Hash::check($data_player_password, $cekPlayerExists->password)) {
                if ($cekPlayerExists->status == 2) {
                    return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
                }

                $cekPlayerExists->makeHidden(['password']);
                $cekPlayerExists->token = $newTokenPlayer;
                $cekPlayerExists->device_id = $head_device_id;
                $cekPlayerExists->device_name = $head_device_name;
                $cekPlayerExists->save();

                $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
                if (is_null($primaryBadge)) {
                    $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
                }
                $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
                $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;

                return ApiFormatter::createApiSuccess('Berhasil masuk', ['Player' => $cekPlayerExists]);
            } else {
                return ApiFormatter::createApiFailed('Email atau kata sandi salah');
            }

        } else {
            $mBaseApplication = BaseApplication::where('id', $head_app_id)->where('app_pkg_secondary', $head_app_pkg)->where('app_secondary_access_key', $head_app_access_key)->first();
            if (is_null($mBaseApplication)) {
                 return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
            }
           
            if (Hash::check($data_player_password, $cekPlayerExists->password)) {
                if ($cekPlayerExists->status == 2) {
                    return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
                }
                $cekPlayerExists->makeHidden(['password']);
                $cekPlayerExists->token = $newTokenPlayer;
                $cekPlayerExists->device_id = $head_device_id;
                $cekPlayerExists->device_name = $head_device_name;
                $cekPlayerExists->save();

                $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
                if (is_null($primaryBadge)) {
                    $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
                }
                $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
                $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;

                return ApiFormatter::createApiSuccess('Berhasil masuk', ['Player' => $cekPlayerExists]);
            } else {
                return ApiFormatter::createApiFailed('Email atau kata sandi salah');
            }
        }

    }

    public static function registerPlayer(Request $request)
    {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');
        $head_is_main_application = $request->header('is_main_application');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_is_main_application) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $data_player_name = $request->player_name;
        $data_player_email = $request->player_email;
        $data_player_password = $request->player_password;

        if (is_null($data_player_name) || is_null($data_player_email) || is_null($data_player_password)) {
            return ApiFormatter::createApiFailed('Harap lengkapi data pendaftaran');
        }

        if (!filter_var($data_player_email, FILTER_VALIDATE_EMAIL)) {
            return ApiFormatter::createApiFailed('Harap masukan email valid');
        }

        $cekPlayerExists = Player::where('player_pkg', $head_app_pkg)
        ->where('email', $data_player_email)
        ->first();

        if (!is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Email ini sudah terdaftar', $cekPlayerExists);
        }

        $deviceList = Device::where('device_id', $head_device_id)->first();
        if (!is_null($deviceList)) {
            if (strcmp($deviceList->player_pkg, $head_app_pkg) === 0) {
                return ApiFormatter::createApiFailed('Satu device hanya bisa digunakan satu kali register, silahkan login menggunakan device sebelumnya');
            }
        }

        $newTokenPlayer = Str::random(100, 'alpha_num_or_symbols');
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';

        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        $player_refferal_code = $randomString;
        // belum
        $player_refferaled_from = null;

        if (Player::where('referral_code', $player_refferal_code)->exists()) {
            $randomString = '';
            for ($i = 0; $i < 16; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $player_refferal_code = $randomString;
        }

        if ($head_is_main_application == 1) {
            $mBaseApplication = BaseApplication::where('id', $head_app_id)->where('app_pkg', $head_app_pkg)->where('app_access_key', $head_app_access_key)->first();
            if (is_null($mBaseApplication)) {
                 return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
            }
            $newPlayer = Player::create([
                'name' => $data_player_name,
                'email' => $data_player_email,
                'password' => bcrypt($data_player_password),
                'referral_code' => $player_refferal_code,
                'player_pkg' => $mBaseApplication->app_pkg,
                'device_id' => $head_device_id,
                'device_name' => $head_device_name,
                'token' => $newTokenPlayer
            ]);
            if ($newPlayer) {
                $primaryBadge = Badge::where('id', $newPlayer->badge_primary)->first();
                if (is_null($primaryBadge)) {
                    $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
                }
                $newPlayer->badge_primary_name = $primaryBadge->badge_name;
                $newPlayer->badge_primary_icon = $primaryBadge->badge_icon;
                $deviceCreate = Device::create([
                    'device_id' => $head_device_id,
                    'player_id' => $newPlayer->id,
                    'player_pkg' => $newPlayer->player_pkg
                ]);
                return ApiFormatter::createApiSuccess('Pendaftaran berhasil dilakukan', ['Player' => $newPlayer]);
            } else {
                return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
            }
        } else {
            $mBaseApplication = BaseApplication::where('id', $head_app_id)->where('app_pkg_secondary', $head_app_pkg)->where('app_secondary_access_key', $head_app_access_key)->first();
            if (is_null($mBaseApplication)) {
                 return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
            }
            $newPlayer = Player::create([
                'name' => $data_player_name,
                'email' => $data_player_email,
                'password' => bcrypt($data_player_password),
                'referral_code' => $player_refferal_code,
                'player_pkg' => $mBaseApplication->app_pkg,
                'device_id' => $head_device_id,
                'device_name' => $head_device_name,
                'token' => $newTokenPlayer
            ]);
            if ($newPlayer) {
                $primaryBadge = Badge::where('id', $newPlayer->badge_primary)->first();
                if (is_null($primaryBadge)) {
                    $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
                }
                $newPlayer->badge_primary_name = $primaryBadge->badge_name;
                $newPlayer->badge_primary_icon = $primaryBadge->badge_icon;
                $deviceCreate = Device::create([
                    'device_id' => $head_device_id,
                    'player_id' => $newPlayer->id,
                    'player_pkg' => $newPlayer->player_pkg
                ]);
                return ApiFormatter::createApiSuccess('Pendaftaran berhasil dilakukan', ['Player' => $newPlayer]);
            } else {
                return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
            }
        }
    }

    // END AUTH

    public static function getQuestionLevelOnCategory(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed( 'ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mCategoryQuizId = $request->id_category;
        $questionsList = Question::where('category_id', $mCategoryQuizId)->select('level')
        ->orderBy('level', 'asc')
        ->get()
        ->pluck('level')
        ->unique()
        ->values()
        ->toArray();

        if (is_null($questionsList) || empty($questionsList)) {
            return ApiFormatter::createApiFailed('Level kuis untuk kategori ini tidak ditemukan');
        }

        return ApiFormatter::createApiSuccess('Data Fetched', [
            'LevelQuiz' => $questionsList
        ]);
       
    }

    public static function getQuestionOnLevelFromCategory(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mCategoryQuizId = $request->id_category;
        $mQuestionLevel = $request->level;
        $mLimitLevel = null;

        if ($mQuestionLevel == 0) {
            $mLimitLevel = 10;
        } elseif ($mQuestionLevel == 1) {
            $mLimitLevel = 12;
        } elseif ($mQuestionLevel == 2) {
            $mLimitLevel = 14;
        } elseif ($mQuestionLevel == 3) {
            $mLimitLevel = 16;
        } else {
            $mLimitLevel = 18;
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)
        ->where('app_access_key', $head_app_access_key)
        ->where('app_pkg', $head_app_pkg)
        ->orWhere('app_pkg_secondary', $head_app_pkg)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        if ($mBaseApplication->settings_date_all_completed == 1) {
            $listOfQuizCompleted = QuizCompleted::where('player_id', $cekPlayerExists->id)
            ->where('category_id', $mCategoryQuizId)
            ->where('category_level', $mQuestionLevel)
            ->where('player_pkg', $cekPlayerExists->player_pkg)
            ->whereDate('created_at', Carbon::now())
            ->first();
        } else {
            $listOfQuizCompleted = QuizCompleted::where('player_id', $cekPlayerExists->id)
            ->where('category_id', $mCategoryQuizId)
            ->where('category_level', $mQuestionLevel)
            ->where('player_pkg', $cekPlayerExists->player_pkg)
            ->first();
        }

        if (!is_null($listOfQuizCompleted)) {
            if ($mBaseApplication->settings_completed_option == 1) {
                return ApiFormatter::createApiFailed('Kamu telah menyelesaikan level '. $mQuestionLevel. ' dari kategori ini');
            }
        }

        $questionsList = Question::where('category_id', $mCategoryQuizId)
        ->where('level', $mQuestionLevel)
        ->limit($mLimitLevel)
        ->inRandomOrder()
        ->get();

        if (is_null($questionsList) || $questionsList->isEmpty()) {
            return ApiFormatter::createApiFailed('Pertanyaan kuis untuk kategori dan level ini tidak ditemukan');
        }

        return ApiFormatter::createApiSuccess('Data Fetched', ['QuestionList' => $questionsList]);
    }

    public static function getListHistoryQuizPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mHistoryQuizPlayerList = HistoryQuiz::where('player_id', $playerLoginId)
        ->orderBy('created_at', 'desc')
        ->get();

        return ApiFormatter::createApiSuccess('Data Fetched', ['HistoryQuiz' => $mHistoryQuizPlayerList]);
    }

    public static function getListHistoryWithdrawPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mHistoryWithdrawPlayerList = Withdrawal::where('player_id', $playerLoginId)
        ->orderBy('created_at', 'desc')
        ->orderBy('updated_at', 'desc')
        ->get();

        return ApiFormatter::createApiSuccess('Data Fetched', ['HistoryWithdraw' => $mHistoryWithdrawPlayerList]);
    }

    public static function getListHistoryCollectedPointPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $listHistoryCollectedPoint = HistoryCollectedPoint::where('player_id', $playerLoginId)
        ->orderBy('created_at', 'desc')
        ->orderBy('updated_at', 'desc')
        ->get();

        return ApiFormatter::createApiSuccess('Data Fetched', ['HistoryCollectedPoint' => $listHistoryCollectedPoint]);
    }

    public static function addRefferalledFromPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $refferalCodeFromPlayer = $request->referral_code;
        $cekPlayerRefferal = Player::where('referral_code', $refferalCodeFromPlayer)
        ->where('player_pkg', $head_app_pkg)
        ->first();

        if (is_null($cekPlayerRefferal)) {
            return ApiFormatter::createApiFailed('Refferal Code tidak ditemukan');
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)
        ->where('app_pkg', $head_app_pkg)
        ->orWhere('app_pkg_secondary', $head_app_pkg)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $cekRefferaled = RefferalPlayer::where('refferaled_registered_player', $playerLoginId)
        ->where('refferaled_from_player', $cekPlayerRefferal->id)
        ->where('player_pkg', $head_app_pkg)
        ->first();

        if (!is_null($cekRefferaled)) {
            return ApiFormatter::createApiFailed('Refferal sudah terkait');
        }

        $newDataRefferal = RefferalPlayer::create([
            'refferaled_registered_player' => $playerLoginId,
            'refferaled_from_player' => $cekPlayerRefferal->id,
            'refferaled_coins_added_to_player' => $mBaseApplication->settings_referral_register_points,
            'player_pkg' => $head_app_pkg
        ]);

        if ($newDataRefferal) {
            $mCreateHistoryCollectedPoint = HistoryCollectedPoint::create([
                'player_id' => $cekPlayerRefferal->id,
                'point_collected_from' => 'app-quiz:'.$mBaseApplication->app_pkg,
                'point_collected_value' => $mBaseApplication->settings_referral_register_points,
                'description' => 'Added commision point from Refferal new player [new-player-email:'.$cekPlayerExists->email.']',
                'player_pkg' => $cekPlayerRefferal->player_pkg
            ]);

            $addCoinsToPlayer = Player::where('id', $cekPlayerRefferal->id)
            ->first();
            $addCoinsToPlayer->points += $mBaseApplication->settings_referral_register_points;
            $addCoinsToPlayer->points_collected += $mBaseApplication->settings_referral_register_points;
            $addCoinsToPlayer->save();
            return ApiFormatter::createApiSuccess('Refferal berhasil dikaitkan');
        } else {
            return ApiFormatter::createApiFailed('Refferal gagal dikaitkan');
        }
    }

    public static function getListHistoryRefferal(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mHistoryRefferaledList = RefferalPlayer::select('refferal_players.*', 'players.name')
        ->join('players', 'refferal_players.refferaled_registered_player', '=', 'players.id')
        ->where('refferal_players.refferaled_from_player', $playerLoginId)
        ->where('refferal_players.player_pkg', $head_app_pkg)
        ->orderBy('created_at', 'desc')
        ->orderBy('updated_at', 'desc')
        ->get();

        return ApiFormatter::createApiSuccess('Data Fetched', ['HistoryRefferal' => $mHistoryRefferaledList]);
    }

    public static function setCompletedQuizPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $questionTotalPointsCollected = $request->points_collected;
        $questionTotalPoints = $request->points_total;
        $questionWithCompletedOptions = $request->completed_option;
        $questionCategoryId = $request->category_id;
        $questionCategoryLevel = $request->category_level;

        if (is_null($questionTotalPointsCollected) || is_null($questionTotalPoints) || is_null($questionWithCompletedOptions) || is_null($questionCategoryId) || is_null($questionCategoryLevel)) {
            return ApiFormatter::createApiFailed('REQUIRED ENTRY');
        }

        $withDoubleOptions = $request->with_double_option;

        if (is_null($withDoubleOptions)) {
            $withDoubleOptions = 0;
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)
        ->where('app_access_key', $head_app_access_key)
        ->where('app_pkg', $head_app_pkg)
        ->orWhere('app_pkg_secondary', $head_app_pkg)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('REQUIRED ENTRY APPLICATION');
        }

        if ($withDoubleOptions == 1) {
            $currPoint = $questionTotalPointsCollected;
            $bonusPoint = $currPoint * ($mBaseApplication->settings_with_double_option_value / 100);
            $questionTotalPointsCollected = $questionTotalPointsCollected + $bonusPoint;
        }

        if ($mBaseApplication->settings_date_all_completed == 1) {
            $listOfQuizCompleted = QuizCompleted::where('player_id', $cekPlayerExists->id)
            ->where('category_id', $questionCategoryId)
            ->where('category_level', $questionCategoryLevel)
            ->where('player_pkg', $cekPlayerExists->player_pkg)
            ->whereDate('created_at', Carbon::now())
            ->first();
        } else {
            $listOfQuizCompleted = QuizCompleted::where('player_id', $cekPlayerExists->id)
            ->where('category_id', $questionCategoryId)
            ->where('category_level', $questionCategoryLevel)
            ->where('player_pkg', $cekPlayerExists->player_pkg)
            ->first();
        }

        

        if (!is_null($listOfQuizCompleted)) {
            return ApiFormatter::createApiFailed('Kamu telah menyelesaikan kategori dan level ini');
        }

        // HandleAddWatchList
        $historyLastQuizCompletedPlayer = QuizCompleted::where('player_id', $cekPlayerExists->id)
        ->latest('created_at')
        ->first();

        if ($historyLastQuizCompletedPlayer) {
            $mQuestionTotalTimer = $mBaseApplication->settings_difference_ms_quiz * 1000;
            $lastCompletedDate = Carbon::parse($historyLastQuizCompletedPlayer->created_at);
            $timeDifferenceInMilliseconds = (int) round($lastCompletedDate->diffInMilliseconds());

            if ($timeDifferenceInMilliseconds < $mQuestionTotalTimer) {

                $cekPlayerExists->status = 1;
                $cekPlayerExists->save();

                $cekIsUserWatched = WatchListPlayer::where('player_id', $cekPlayerExists->id)
                ->where('player_pkg', $cekPlayerExists->player_pkg)
                ->first();

                $reason = 'Detected spam indicating completion of quiz at : ' . now()->locale('id')->format('d-m-Y H:i:s');

                if ($cekIsUserWatched) {
                    $existReasons = $cekIsUserWatched->reason ?? [];
                    $existReasons[] = $reason;
                    $cekIsUserWatched->reason = $existReasons;
                    $cekIsUserWatched->save();
                } else {
                    WatchListPlayer::create([
                        'player_id' => $cekPlayerExists->id,
                        'reason' => [$reason],
                        'player_pkg' => $cekPlayerExists->player_pkg
                    ]);
                }

                return ApiFormatter::createApiFailed(
                    'Terjadi indikasi kecurangan, akun kamu sedang dalam pengawasan. Hubungi admin jika ini merupakan suatu kesalahan'
                );
            }
        }

        // ads_watched_inters
        $countWatchInters = $request->awi ?? 0;
        // ads_watched_rewards
        $countWatchRewards = $request->awr ?? 0;

        $mNewHistoryQuizPlayer = HistoryQuiz::create([
            'player_id' => $cekPlayerExists->id,
            'score' => $questionTotalPointsCollected,
            'points' => $questionTotalPointsCollected,
            'ads_watched_inters' => $countWatchInters,
            'ads_watched_rewards' => $countWatchRewards,
            'category_id' => $questionCategoryId,
            'category_level' => $questionCategoryLevel,
            'total_quiz_points' => $questionTotalPoints,
            'completed_option' => $questionWithCompletedOptions,
            'with_double_option' => $withDoubleOptions,
            'description' => 'PLAYING QUIZ',
            'player_pkg' => $cekPlayerExists->player_pkg
        ]);

        if ($mNewHistoryQuizPlayer) {
            $mNewCompletedQuiz = QuizCompleted::create([
                'player_id' => $cekPlayerExists->id,
                'category_id' => $questionCategoryId,
                'category_level' => $questionCategoryLevel,
                'is_use_completed' => $questionWithCompletedOptions,
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);
            $mCreateHistoryCollectedPoint = HistoryCollectedPoint::create([
                'player_id' => $cekPlayerExists->id,
                'point_collected_from' => 'app-quiz:'.$mBaseApplication->app_pkg,
                'point_collected_value' => $questionTotalPointsCollected,
                'description' => 'Playing quiz',
                'ads_watched_inters_is_exist' => $countWatchInters,
                'ads_watched_rewards_is_exist' => $countWatchRewards,
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);
            $mAddCounterTemporary = AdsCounterTemporary::create([
                'player_id' => $cekPlayerExists->id,
                'description' => 'KUIS',
                'ads_watched_inters' => $countWatchInters,
                'ads_watched_rewards' => $countWatchRewards,
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);

            $cekPlayerExists->score += $questionTotalPointsCollected;
            $cekPlayerExists->points += $questionTotalPointsCollected;
            $cekPlayerExists->points_collected += $questionTotalPointsCollected;
            $cekPlayerExists->save();
            $cekPlayerExists->makeHidden(['password']);
            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;
            return ApiFormatter::createApiSuccess('Data Fetched', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
        }
    }

    public static function getPlayerListRanksByScores(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mPlayerList = Player::where('player_pkg', $head_app_pkg)
        ->orderBy('score', 'desc')
        ->limit(50)
        ->get();

        $mPlayerList->each(function ($player) {
            $player->makeHidden(['password', 'token', 'real_player', 'status', 'email', 'referral_code', 'device_name', 'device_id']);
            $primaryBadge = Badge::where('id', $player->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $player->badge_primary_name = $primaryBadge->badge_name;
            $player->badge_primary_icon = $primaryBadge->badge_icon;
        });


        if ($mPlayerList) {
            return ApiFormatter::createApiSuccess('Data Fetched', ['PlayerRanks' => $mPlayerList]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
        }
    }

    public static function refreshDataPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        if ($cekPlayerExists) {
            $cekPlayerExists->makeHidden(['password']);
            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;
            return ApiFormatter::createApiSuccess('Data Fetched', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function changePasswordPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $playerLoginPassword = $request->player_password;
        
        if (is_null($playerLoginId) || is_null($playerLoginToken) || is_null($playerLoginPassword)) {
            return ApiFormatter::createApiFailed('DATA DIPERLUKAN!');
        }

        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $cekPlayerExists->password = bcrypt($playerLoginPassword);
        $cekPlayerExists->save();

        if ($cekPlayerExists) {
            $cekPlayerExists->makeHidden(['password']);
            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;
            return ApiFormatter::createApiSuccess('Password berhasil dirubah', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function editDataPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $playerNameChanged = $request->player_name;

        if (is_null($playerNameChanged)) {
            return ApiFormatter::createApiFailed('Data diperlukan');
        }

        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $cekPlayerExists->name = $playerNameChanged;
        $cekPlayerExists->save();

        if ($cekPlayerExists) {
            $cekPlayerExists->makeHidden(['password']);
            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;
            return ApiFormatter::createApiSuccess('Data kamu berhasil di ubah', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function editAvatarPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $playerAvatarChanged = $request->avatar_id;

        if (is_null($playerAvatarChanged)) {
            return ApiFormatter::createApiFailed('Data diperlukan');
        }

        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $cekAvatar = Avatar::where("id", $playerAvatarChanged)->first();
        if (is_null($cekAvatar)) {
            return ApiFormatter::createApiFailed('Terjadi suatu kesalahan');
        }

        $cekPlayerExists->image_url = $cekAvatar->avatar_icon;
        $cekPlayerExists->save();

        if ($cekPlayerExists) {
            $cekPlayerExists->makeHidden(['password']);
            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;
            return ApiFormatter::createApiSuccess('Avatar kamu berhasil di ubah', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function logoutPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;

        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $cekPlayerExists->device_name = null;
        $cekPlayerExists->device_id = null;
        $cekPlayerExists->token = null;
        $cekPlayerExists->save();

        if ($cekPlayerExists) {
            $cekPlayerExists->makeHidden(['password']);
            return ApiFormatter::createApiSuccess('Kamu berhasil logout');
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function requestWithdrawPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)
        ->where('app_pkg', $head_app_pkg)
        ->orWhere('app_pkg_secondary', $head_app_pkg)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('Terjadi kesalahan akses aplikasi');
        }

        if ($mBaseApplication->settings_menu_wd_pending == 1) {
            return ApiFormatter::createApiFailed($mBaseApplication->$settings_menu_message_wd_pending);
        }

        $playerPointAmount = $request->player_point;
        $playerMethodId = $request->player_payment_id;

        $playerReceivedAmount = $playerPointAmount / $mBaseApplication->settings_min_to_withdraw * $mBaseApplication->settings_conversion_rate;
        $playerPaymentAccount = $request->player_payment_account;

        if (is_null($playerPointAmount) || is_null($playerMethodId) || is_null($playerReceivedAmount) || is_null($playerPaymentAccount)) {
            return ApiFormatter::createApiFailed('Permintaan tidak valid');
        }

        if ($playerPointAmount < $mBaseApplication->settings_min_to_withdraw) {
            return ApiFormatter::createApiFailed('Permintaan penarikan gagal dikarenakan jumlah point yang diminta tidak mencukupi dari minimal withdraw');
        }

        if ($playerPointAmount > $cekPlayerExists->points) {
            return ApiFormatter::createApiFailed('Permintaan penarikan gagal dikarenakan jumlah point yang kamu miliki tidak sesuai dari permintaan withdraw');
        }

        $mWithdraw = Withdrawal::create([
            'player_id' => $cekPlayerExists->id,
            'player_pkg' => $cekPlayerExists->player_pkg,
            'amount' => $playerReceivedAmount,
            'points' => $playerPointAmount,
            'payment_method' => $playerMethodId,
            'payment_account' => $playerPaymentAccount
        ]);

        if ($mWithdraw) {
            $cekPlayerExists->points -= $playerPointAmount;
            $cekPlayerExists->save();
            
            return ApiFormatter::createApiSuccess('Request withdrawal completed', ['Withdrawal' => $mWithdraw]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function getCurrentCompletedNewPointKaget(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $pointKagetId = $request->rewardsadpoint_id;

        if (empty($playerLoginId) || empty($pointKagetId)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $cekPlayerExists = Player::where('player_pkg', $request->header('app_pkg'))
        ->where('id', $playerLoginId)
        ->first();

        if (!$cekPlayerExists) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $cekPointKagetExist = RewardsAdPoints::find($pointKagetId);

        if (!$cekPointKagetExist) {
            return ApiFormatter::createApiFailed('POINT KAGET TIDAK DITEMUKAN');
        }

        $getTaskCompleted = CompletedPointKaget::where('rewardsadpoint_id', $pointKagetId)
        ->where('player_id', $playerLoginId)
        ->whereDate('created_at', Carbon::now())
        ->first();

        if ($getTaskCompleted) {
            if ($getTaskCompleted->is_claimmed == 1) {
                return ApiFormatterV2::createApiPointKagetTaskFinish(null, [
                    'CurrentPointKaget' => $getTaskCompleted,
                    'RewardsAdPoint' => $cekPointKagetExist,
                    'Player' => $cekPlayerExists
                ]);
            } else {
                return ApiFormatter::createApiSuccess('Data Fetched Current Task', [
                    'CurrentPointKaget' => $getTaskCompleted,
                    'RewardsAdPoint' => $cekPointKagetExist,
                    'Player' => $cekPlayerExists
                ]);
            }
        } else {
            return ApiFormatter::createApiSuccess('Data Fetched New Task', [
                'RewardsAdPoint' => $cekPointKagetExist,
                'Player' => $cekPlayerExists
            ]);
        }

    }

    public static function setCompletedNewPointKaget(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $pointKagetId = $request->rewardsadpoint_id;

        if (empty($playerLoginId) || empty($pointKagetId)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $cekPlayerExists = Player::where('player_pkg', $request->header('app_pkg'))
        ->where('id', $playerLoginId)
        ->first();

        if (!$cekPlayerExists) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $cekPointKagetExist = RewardsAdPoints::find($pointKagetId);

        if (!$cekPointKagetExist) {
            return ApiFormatter::createApiFailed('POINT KAGET TIDAK DITEMUKAN');
        }

        $countWatchInters = $request->awi ?? 0;
        $countWatchRewards = $request->awr ?? 0;

        $getTaskCompleted = CompletedPointKaget::where('rewardsadpoint_id', $pointKagetId)
        ->where('player_id', $playerLoginId)
        ->whereDate('created_at', Carbon::now())
        ->first();

        if ($getTaskCompleted) {
            $taskPointKagetValue = $cekPointKagetExist->watch_ads_value;

            if ($getTaskCompleted->task_count < $taskPointKagetValue) {
                $getTaskCompleted->task_count += 1;
                $getTaskCompleted->ads_watched_inters_is_exist += $countWatchInters;
                $getTaskCompleted->ads_watched_rewards_is_exist += $countWatchRewards;

                if ($getTaskCompleted->save()) {
                    if ($getTaskCompleted->task_count == $taskPointKagetValue) {
                        return self::claimTaskAndReward($getTaskCompleted, $cekPlayerExists, $cekPointKagetExist, $head_app_pkg);
                    }

                    $mAddCounterTemporary = AdsCounterTemporary::create([
                        'player_id' => $cekPlayerExists->id,
                        'description' => 'POINT KAGET',
                        'ads_watched_inters' => $countWatchInters,
                        'ads_watched_rewards' => $countWatchRewards,
                        'player_pkg' => $cekPlayerExists->player_pkg
                    ]);

                    return ApiFormatterV2::createApiPointKagetTaskNext(null, [
                        'CurrentPointKaget' => $getTaskCompleted,
                        'RewardsAdPoint' => $cekPointKagetExist,
                        'Player' => $cekPlayerExists
                    ]);
                } else {
                    return ApiFormatterV2::createApiFailed('Terjadi kesalahan sistem, silahkan coba lagi');
                }
            } 
            else if ($getTaskCompleted->task_count == $taskPointKagetValue) {
                return self::claimTaskAndReward($getTaskCompleted, $cekPlayerExists, $cekPointKagetExist, $head_app_pkg);
            } 
            else {
                return ApiFormatterV2::createApiPointKagetTaskFinish(null, [
                    'CurrentPointKaget' => $getTaskCompleted,
                    'RewardsAdPoint' => $cekPointKagetExist,
                    'Player' => $cekPlayerExists
                ]);
            }
        } 
        else {
            $newCompletedTask = CompletedPointKaget::create([
                'rewardsadpoint_id' => $pointKagetId,
                'player_id' => $playerLoginId,
                'task_count' => 1,
                'bonus_points' => $cekPointKagetExist->point_value,
                'is_claimmed' => 0,
                'ads_watched_inters_is_exist' => $countWatchInters,
                'ads_watched_rewards_is_exist' => $countWatchRewards,
                'player_pkg' => $cekPlayerExists->player_pkg,
            ]);
            if ($newCompletedTask) {
                return ApiFormatterV2::createApiPointKagetTaskNext(null, [
                    'CurrentPointKaget' => $newCompletedTask,
                    'RewardsAdPoint' => $cekPointKagetExist,
                    'Player' => $cekPlayerExists
                ]);
            } else {
                return ApiFormatterV2::createApiFailed('Terjadi kesalahan sistem, silahkan coba lagi');
            }
        }
    }


    private static function claimTaskAndReward($getTaskCompleted, $cekPlayerExists, $cekPointKagetExist, $head_app_pkg) {
        $getTaskCompleted->is_claimmed = 1;

        if ($getTaskCompleted->save()) {
            $cekPlayerExists->points += $cekPointKagetExist->point_value;
            $cekPlayerExists->points_collected += $cekPointKagetExist->point_value;

            if ($cekPlayerExists->save()) {
                HistoryCollectedPoint::create([
                    'player_id' => $cekPlayerExists->id,
                    'point_collected_from' => 'app-quiz:' . $head_app_pkg,
                    'point_collected_value' => $cekPointKagetExist->point_value,
                    'ads_watched_rewards_is_exist' => $getTaskCompleted->ads_watched_rewards_is_exist,
                    'description' => 'Claimed point from Point Kaget',
                    'player_pkg' => $cekPlayerExists->player_pkg
                ]);

                HistoryCollectedRewardsAdPoint::create([
                    'player_id' => $cekPlayerExists->id,
                    'rewardsadpoint_id' => $cekPointKagetExist->id,
                    'player_pkg' => $cekPlayerExists->player_pkg
                ]);

                return ApiFormatterV2::createApiPointKagetTaskFinish(null, [
                    'CurrentPointKaget' => $getTaskCompleted,
                    'RewardsAdPoint' => $cekPointKagetExist,
                    'Player' => $cekPlayerExists
                ]);
            } else {
                return ApiFormatterV2::createApiFailed('Terjadi kesalahan sistem, silahkan coba lagi');
            }
        } else {
            return ApiFormatterV2::createApiFailed('Terjadi kesalahan sistem, silahkan coba lagi');
        }
    }


    public static function validationPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $app_selected = $request->package_external;
        $playerEmail = $request->email;

        if (is_null($app_selected) || is_null($playerEmail)) {
            return ApiFormatter::createApiFailed('Data Required');
        }
        
        $cekPlayerExists = Player::where('player_pkg', $app_selected)
        ->where('email', $playerEmail)
        ->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Player tidak ditemukan');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }
        return ApiFormatter::createApiSuccess('Data Fetched', ['Player' => $cekPlayerExists]);
    }

    public static function getCountdownTimeCollectPointExternal(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $app_selected = $request->package_external;
        if (is_null($app_selected)) {
            return ApiFormatter::createApiFailed('Data Required');
        }

        $playerEmail = $request->email;
        $cekPlayerExists = Player::where('player_pkg', $app_selected)
        ->where('email', $playerEmail)
        ->first();
        if (is_null($cekPlayerExists)) {
            return ApiFormatterV2::createApiExtReinputEmail();
        }

        $mBaseApplication = BaseApplication::where('app_pkg', $app_selected)
        ->orWhere('app_pkg_secondary', $app_selected)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('Terjadi suatu kesalahan server silahkan coba lagi');
        } else {
            if ($mBaseApplication->app_ext_pkg_allow_access == 0) {
                return ApiFormatter::createApiFailed('Sementara survey artikel tidak bisa digunakan, silahkan coba lagi nanti.'); 
            }
        }

        if ($mBaseApplication->settings_date_all_completed == 1) {
            $listOfCompletedArticlePoint = CompletedArticlePoint::where('player_pkg', $app_selected)
            ->where('player_id', $cekPlayerExists->id)
            ->whereDate('created_at', Carbon::now())
            ->get();
        } else {
            $listOfCompletedArticlePoint = CompletedArticlePoint::where('player_pkg', $app_selected)
            ->where('player_id', $cekPlayerExists->id)
            ->get();
        }

        $countLimit = $mBaseApplication->settings_menu_limit_count_claim_external;

        if ($listOfCompletedArticlePoint->isEmpty()) {
            return ApiFormatter::createApiSuccess('OK');
        } elseif ($listOfCompletedArticlePoint->count() >= $countLimit) {
            return ApiFormatter::createApiFailed('Anda telah mencapai batas harian untuk mengklaim survei ini. Silakan lanjutkan kembali besok.');
        } else {
            return ApiFormatterV2::createApiExtWaitingClaim('WAITING CLAIM', [
                'TimeCountdown' => $mBaseApplication->settings_menu_limit_time_claim_external
            ]);
        }


    }

    public static function collectPointExternal(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $app_selected = $request->package_external;
        if (is_null($app_selected)) {
            return ApiFormatter::createApiFailed('Data Required');
        }
        $playerEmail = $request->email;
        $pointCollected = $request->point;
        $cekPlayerExists = Player::where('player_pkg', $app_selected)
        ->where('email', $playerEmail)
        ->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Player tidak ditemukan');
        }

        if (is_null($pointCollected)) {
            return ApiFormatter::createApiFailed('Data tidak valid');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mBaseApplication = BaseApplication::where('app_pkg', $app_selected)
        ->orWhere('app_pkg_secondary', $app_selected)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('Terjadi suatu kesalahan server silahkan coba lagi');
        } else {
            if ($mBaseApplication->app_ext_pkg_allow_access == 0) {
                return ApiFormatter::createApiFailed('Sementara survey artikel tidak bisa digunakan, silahkan coba lagi nanti.'); 
            }
        }

        if ($mBaseApplication->settings_date_all_completed == 1) {
            $listOfCompletedArticlePoint = CompletedArticlePoint::where('player_pkg', $app_selected)
            ->where('player_id', $cekPlayerExists->id)
            ->whereDate('created_at', Carbon::now())
            ->get();
        } else {
            $listOfCompletedArticlePoint = CompletedArticlePoint::where('player_pkg', $app_selected)
            ->where('player_id', $cekPlayerExists->id)
            ->get();
        }
        

        if (!is_null($listOfCompletedArticlePoint)) {
            if ($listOfCompletedArticlePoint->count() >= $mBaseApplication->settings_menu_limit_count_claim_external) {
                return ApiFormatter::createApiFailed('Anda telah mencapai batas harian untuk mengklaim survei ini. Silakan lanjutkan kembali besok.');
            } 
        }

        $cekPlayerExists->points += $pointCollected; 
        $cekPlayerExists->points_collected += $pointCollected; 
        $cekPlayerExists->save();

        // ads_watched_inters
        $countWatchInters = $request->awi ?? 0;
        // ads_watched_rewards
        $countWatchRewards = $request->awr ?? 0;
        // count article
        $countWatchArticleCount = $request->article_count ?? 0;

        if ($cekPlayerExists) {
            $cekPlayerExists->makeHidden(['password']);
            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;
            $mCreateHistoryCollectedPoint = HistoryCollectedPoint::create([
                'player_id' => $cekPlayerExists->id,
                'point_collected_from' => 'app-quiz:'.$head_app_pkg,
                'point_collected_value' => $pointCollected,
                'description' => 'Added point from external application ['.$head_app_pkg.']',
                'ads_watched_inters_is_exist' => $countWatchInters,
                'ads_watched_rewards_is_exist' => $countWatchRewards,
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);

            $createHistoryPlayer = HistoryQuiz::create([
                'player_id' => $cekPlayerExists->id,
                'score' => 0,
                'points' => $pointCollected,
                'ads_watched_inters' => $countWatchInters,
                'ads_watched_rewards' => $countWatchRewards,
                'category_id' => 'app_ext:'.$head_app_pkg,
                'category_level' => 0,
                'total_quiz_points' => $pointCollected,
                'completed_option' => 0,
                'with_double_option' => 0,
                'description' => 'TASK EXTERNALL APP',
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);

            $createCompletedArticlePoint = CompletedArticlePoint::create([
                'player_id' => $cekPlayerExists->id,
                'article_count' => $countWatchArticleCount,
                'bonus_points' => $pointCollected,
                'ads_watched_inters_is_exist' => $countWatchInters,
                'ads_watched_rewards_is_exist' => $countWatchRewards,
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);

            $mAddCounterTemporary = AdsCounterTemporary::create([
                'player_id' => $cekPlayerExists->id,
                'description' => 'ARTIKEL POINT',
                'ads_watched_inters' => $countWatchInters,
                'ads_watched_rewards' => $countWatchRewards,
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);

            return ApiFormatter::createApiSuccess('Data Fetched', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function getListCollectedBadgeOnPlayer(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        
        if (is_null($playerLoginId) || is_null($playerLoginToken)) {
            return ApiFormatter::createApiFailed('DATA DIPERLUKAN!');
        }

        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $badgesOnPlayer = HistoryExchangeBadgePlayer::where('player_id', $cekPlayerExists->id)
        ->get();
        $badgeCounts = $badgesOnPlayer->groupBy('badge_id')->map(function ($group) {
            return $group->count();
        });
        $badgeIds = $badgeCounts->keys();
        $mBadgeListWithCount = Badge::whereIn('id', $badgeIds)->get()->map(function ($badge) use ($badgeCounts) {
            $badge->count = $badgeCounts[$badge->id];
            return $badge;
        });

        if (!$mBadgeListWithCount->isEmpty()) {
            return ApiFormatter::createApiSuccess('Data Fetched', ['ListCollectedBadge' => $mBadgeListWithCount]);
        } else {
            return ApiFormatter::createApiFailed('Koleksi badge kamu masih kosong');
        }
    }

    public static function requestExchangeBadge(Request $request)
    {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');
        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)
        ->where('app_pkg', $head_app_pkg)
        ->orWhere('app_pkg_secondary', $head_app_pkg)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('Terjadi kesalahan akses aplikasi');
        }

        $badgeSelectedExchangeId = $request->badge_id;

        if (is_null($badgeSelectedExchangeId)) {
            return ApiFormatter::createApiFailed('Permintaan tidak valid');
        }

        $badgeSelected = Badge::find($badgeSelectedExchangeId);

        if (is_null($badgeSelected)) {
            return ApiFormatter::createApiFailed('Badge yang dipilih tidak tersedia');
        }

        if ($badgeSelected->badge_price > $cekPlayerExists->points) {
            return ApiFormatter::createApiFailed('Permintaan penukaran badge gagal dikarenakan jumlah point yang ditukar tidak mencukupi dari harga badge');
        }

        $mHistoryExchangeBadgePlayer = HistoryExchangeBadgePlayer::create([
            'player_id' => $cekPlayerExists->id,
            'badge_id' => $badgeSelected->id,
            'player_pkg' => $cekPlayerExists->player_pkg
        ]);

        if ($mHistoryExchangeBadgePlayer) {
            $cekPlayerExists->points -= $badgeSelected->badge_price;
            $cekPlayerExists->badge_primary = $badgeSelected->id;
            // $badgePlayer = $cekPlayerExists->badge_player;

            // $badgePlayer[] = $badgeSelected->id;
            // $cekPlayerExists->badge_player = $badgePlayer;
            $cekPlayerExists->save();

            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;

            return ApiFormatter::createApiSuccess('Request exchange badge completed', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }

    public static function collectRewardsAdPoint(Request $request) {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');
        $head_device_id = $request->header('device_id');
        $head_device_name = $request->header('device_name');

        if (is_null($head_app_id) || is_null($head_app_pkg) || is_null($head_app_code) || is_null($head_app_access_key) || is_null($head_device_id) || is_null($head_device_name)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $playerLoginId = $request->player_id;
        $playerLoginToken = $request->player_token;
        $cekPlayerExists = Player::where('id', $playerLoginId)->where('token', $playerLoginToken)->where('player_pkg', $head_app_pkg)->first();

        if (is_null($cekPlayerExists)) {
            return ApiFormatter::createApiFailed('Silahkan login terlebih dahulu');
        }

        if ($cekPlayerExists->status == 2) {
            return ApiFormatter::createApiFailed('Akun kamu telah di banned dari aplikasi, harap hubungi admin');
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)
        ->where('app_pkg', $head_app_pkg)
        ->orWhere('app_pkg_secondary', $head_app_pkg)
        ->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('Terjadi kesalahan akses aplikasi');
        }

        $rewardsAdPointId = $request->rewards_ad_points_id;

        if (is_null($rewardsAdPointId)) {
            return ApiFormatter::createApiFailed('Permintaan tidak valid');
        }

        $rewardSeledted = RewardsAdPoints::find($rewardsAdPointId);

        if (is_null($rewardSeledted)) {
            return ApiFormatter::createApiFailed('Rewards ad point tidak tersedia');
        }

        $mCreateHistoryCollectedPoint = HistoryCollectedPoint::create([
            'player_id' => $cekPlayerExists->id,
            'point_collected_from' => 'app-quiz:'.$mBaseApplication->app_pkg,
            'point_collected_value' => $rewardSeledted->point_value,
            'description' => 'Claimed point from Point Kaget',
            'player_pkg' => $cekPlayerExists->player_pkg
        ]);

        if ($mCreateHistoryCollectedPoint) {
            $mCreateHistoryCollectedRewardsAdPoint = HistoryCollectedRewardsAdPoint::create([
                'player_id' => $cekPlayerExists->id,
                'rewardsadpoint_id' => $rewardSeledted->id,
                'player_pkg' => $cekPlayerExists->player_pkg
            ]);

            $cekPlayerExists->points += $rewardSeledted->point_value;
            // added collected point tracking rewards ad point 6/8/2024
            $cekPlayerExists->points_collected += $rewardSeledted->point_value;
            $cekPlayerExists->save();

            $primaryBadge = Badge::where('id', $cekPlayerExists->badge_primary)->first();
            if (is_null($primaryBadge)) {
                $primaryBadge = Badge::where('id', '93ced448-732b-4008-a17f-b8a89a294097')->first();
            }
            $cekPlayerExists->badge_primary_name = $primaryBadge->badge_name;
            $cekPlayerExists->badge_primary_icon = $primaryBadge->badge_icon;
            
            return ApiFormatter::createApiSuccess('Claimed Point Kaget Success', ['Player' => $cekPlayerExists]);
        } else {
            return ApiFormatter::createApiFailed('Terjadi kesalahan silahkan coba lagi');
        }
    }


}
