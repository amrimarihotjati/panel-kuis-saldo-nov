<?php

namespace App\Http\Controllers;

use App\Models\BaseApplication;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class BaseApplicationController extends Controller
{

   public function getDTBaseApplication(Request $request)
    {
        $query = BaseApplication::query()->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountBaseApplication(Request $request)
    {
        $data = BaseApplication::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createBaseApplication(Request $request)
    {
        $app_pkg = $request->app_pkg;

        $accessKey = Str::random(100, 'alpha_num_or_symbols');
        $accessKeySecondary = Str::random(100, 'alpha_num_or_symbols');
        $accessKeyExternal = Str::random(100, 'alpha_num_or_symbols');

        if (BaseApplication::where('app_access_key', $accessKey)->exists()) {
            $accessKey = Str::random(100, 'alpha_num_or_symbols');
        }

        if (BaseApplication::where('app_secondary_access_key', $accessKeySecondary)->exists()) {
            $accessKeySecondary = Str::random(100, 'alpha_num_or_symbols');
        }

        $category_quiz = [];
        $dana_kaget = [];
        $banner = [];
        $rewardsAdPoint = [];

        $mBaseApplication = BaseApplication::create([
            'app_pkg' => $app_pkg,
            'app_access_key' => $accessKey,
            'app_secondary_access_key' => $accessKeySecondary,
            'app_ext_pkg_access_key' => $accessKeyExternal,
            'category_quiz' => $category_quiz,
            'dana_kaget' => $dana_kaget,
            'banner' => $banner,
            'rewards_ad_points' => $rewardsAdPoint
        ]);

        if ($mBaseApplication) {
            return response()->json(['message' => 'Aplikasi berhasil dibuat'], 200);
        } else {
            return response()->json(['message' => 'Aplikasi gagal dibuat'], 500);
        }
    }

    public function deleteBaseApplication($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        $mBaseApplication->delete();
        if ($mBaseApplication) {
           return redirect('/base-application');
        } else {
           return response()->json(['message' => 'BaseApplication gagal dihapus'], 500);
       }
    }

    public function goEditData($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/edit/edit-base-application', compact('mBaseApplication'));
    }

    public function goEditConfigAd($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/config-ad', compact('mBaseApplication'));
    }

    public function goCollectedPoint($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/collected-point', compact('mBaseApplication'));
    }

    public function goCompletedQuiz($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/completed-quiz', compact('mBaseApplication'));
    }

    public function goHistoryQuiz($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/history-quiz', compact('mBaseApplication'));
    }

    public function goHistoryRefferal($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/history-refferal', compact('mBaseApplication'));
    }

    public function goHistoryWithdraw($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        $mWithdrawalTotalAmount = Withdrawal::where('player_pkg', $mBaseApplication->app_pkg)
        ->where('status', 1)
        ->get()->sum('amount');
        $mWithdrawalTotalAmountPending = Withdrawal::where('player_pkg', $mBaseApplication->app_pkg)
        ->where('status', 0)
        ->get()->sum('amount');
        return view('layouts/page/inview/base-application/history-withdraw', compact('mBaseApplication', 'mWithdrawalTotalAmount', 'mWithdrawalTotalAmountPending'));
    }

    public function getTotalWithdrawalAccepted($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        $mWithdrawalTotalAmount = Withdrawal::where('player_pkg', $mBaseApplication->app_pkg)
        ->where('status', 1)
        ->get()->sum('amount');
        return $mWithdrawalTotalAmount;
    }

    public function goListPlayer($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/list-player', compact('mBaseApplication'));
    }

    public function goPantauPlayer($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/pantau-player', compact('mBaseApplication'));
    }

    public function goWatchListPlayer($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/watchlist-player', compact('mBaseApplication'));
    }

    public function goHistoryExchangeBadgePlayer($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/history-exchange-badge', compact('mBaseApplication'));
    }

    public function goHistoryCollectedRewardsAdPoint($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/history-collected-rewardsadpoint', compact('mBaseApplication'));
    }

    public function goCompletedArticlePoint($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/completed-article-point', compact('mBaseApplication'));
    }

    public function goCompletedPointKaget($id) {
        $mBaseApplication = BaseApplication::findOrFail($id);
        return view('layouts/page/inview/base-application/completed-point-kaget', compact('mBaseApplication'));
    }

    // INNERVIEW
     public function saveMainSettings(Request $request) {
        $app_id = $request->app_id;
        $app_pkg = $request->app_pkg;
        $app_code = $request->app_code;
        $app_access_key = $request->app_access_key;
        $app_url_redirect = $request->app_url_redirect;
        $app_is_redirect = $request->app_is_redirect;

        $settings_menu_wd_pending = $request->settings_menu_wd_pending;
        $settings_menu_message_wd_pending = $request->settings_menu_message_wd_pending;

        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->app_code = $app_code;
        $mBaseApplication->app_url_redirect = $app_url_redirect;
        $mBaseApplication->app_is_redirect = $app_is_redirect;
        $mBaseApplication->settings_menu_wd_pending = $settings_menu_wd_pending;
        $mBaseApplication->settings_menu_message_wd_pending = $settings_menu_message_wd_pending;
        
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveSecondarySettings(Request $request) {
        $app_id = $request->app_id;
        $app_pkg_secondary = $request->app_pkg_secondary;
        $app_secondary_code = $request->app_secondary_code;
        $app_secondary_access_key = $request->app_secondary_access_key;

        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->app_pkg_secondary = $app_pkg_secondary;
        $mBaseApplication->app_secondary_code = $app_secondary_code;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveExternalSettings(Request $request) {
        $app_id = $request->app_id;
        $app_ext_pkg_name = $request->app_ext_pkg_name;
        $app_ext_pkg_allow_access = $request->app_ext_pkg_allow_access;
        $app_ext_pkg_access_key = $request->app_ext_pkg_access_key;
        $settings_menu_limit_time_claim_external = $request->settings_menu_limit_time_claim_external;
        $settings_menu_limit_count_claim_external = $request->settings_menu_limit_count_claim_external;

        
        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->app_ext_pkg_name = $app_ext_pkg_name;
        $mBaseApplication->app_ext_pkg_allow_access = $app_ext_pkg_allow_access;
        $mBaseApplication->settings_menu_limit_time_claim_external = $settings_menu_limit_time_claim_external;
        $mBaseApplication->settings_menu_limit_count_claim_external = $settings_menu_limit_count_claim_external;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveMaintananceSettings(Request $request) {
        $app_id = $request->app_id;
        $app_is_maintanance = $request->app_is_maintanance;
        $app_msg_maintanance = $request->app_msg_maintanance;
        
        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->app_is_maintanance = $app_is_maintanance;
        $mBaseApplication->app_msg_maintanance = $app_msg_maintanance;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveAddDagetSettings(Request $request) {
        $app_id = $request->app_id;
        $selectedDaget = $request->input('mDaget', []);
        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->dana_kaget = $selectedDaget;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveAddRewardsAdPointsSettings(Request $request) {
        $app_id = $request->app_id;
        $selectedRewardsAdPoints = $request->input('mRewardsAdPoints', []);
        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->rewards_ad_points = $selectedRewardsAdPoints;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveAddCategoryQuizSettings(Request $request) {
        $app_id = $request->app_id;
        $category_quiz = $request->input('mCategoryQuiz', []);
        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->category_quiz = $category_quiz;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveAddBannerSettings(Request $request) {
        $app_id = $request->app_id;
        $banner = $request->input('mBanner', []);
        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->banner = $banner;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveAddBadgeSettings(Request $request) {
        $app_id = $request->app_id;
        $badge = $request->input('mBadge', []);
        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->badge = $badge;
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    // ADS CONFIG

    public function saveConfigAdsFlow(Request $request) {
        $app_id = $request->app_id;
        $mBaseApplication = BaseApplication::findOrFail($app_id);

        $settings_module_ads_first = $request->settings_module_ads_first;
        $settings_module_ads_secondary = $request->settings_module_ads_secondary;
        $settings_module_ads_third = $request->settings_module_ads_third;

        $mBaseApplication->settings_module_ads_first = $settings_module_ads_first;
        $mBaseApplication->settings_module_ads_secondary = $settings_module_ads_secondary;
        $mBaseApplication->settings_module_ads_third = $settings_module_ads_third;
        $mBaseApplication->save();

        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveConfigAdsVungle(Request $request) {
        $app_id = $request->app_id;

        $vungle_app_id_or_sdk_key = $request->vungle_app_id_or_sdk_key;
        $vungle_placement_banner = $request->vungle_placement_banner;
        $vungle_placement_native = $request->vungle_placement_native;
        $vungle_placement_interstitial = $request->vungle_placement_interstitial;
        $vungle_placement_rewards = $request->vungle_placement_rewards;

        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->vungle_app_id_or_sdk_key = $vungle_app_id_or_sdk_key;
        $mBaseApplication->vungle_placement_banner = $vungle_placement_banner;
        $mBaseApplication->vungle_placement_native = $vungle_placement_native;
        $mBaseApplication->vungle_placement_interstitial = $vungle_placement_interstitial;
        $mBaseApplication->vungle_placement_rewards = $vungle_placement_rewards;

        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveConfigAdsVungleBidding(Request $request) {
        $app_id = $request->app_id;

        $vungle_placement_bidding_banner = $request->vungle_placement_bidding_banner;
        $vungle_placement_bidding_native = $request->vungle_placement_bidding_native;
        $vungle_placement_bidding_interstitial = $request->vungle_placement_bidding_interstitial;
        $vungle_placement_bidding_rewards = $request->vungle_placement_bidding_rewards;

        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->vungle_placement_bidding_banner = $vungle_placement_bidding_banner;
        $mBaseApplication->vungle_placement_bidding_native = $vungle_placement_bidding_native;
        $mBaseApplication->vungle_placement_bidding_interstitial = $vungle_placement_bidding_interstitial;
        $mBaseApplication->vungle_placement_bidding_rewards = $vungle_placement_bidding_rewards;

        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveConfigAdsApplovinmax(Request $request) {
        $app_id = $request->app_id;
        $applovinmax_app_id_or_sdk_key = $request->applovinmax_app_id_or_sdk_key;
        $applovinmax_placement_banner_no_ecpm = $request->applovinmax_placement_banner_no_ecpm;
        $applovinmax_placement_native_no_ecpm = $request->applovinmax_placement_native_no_ecpm;
        $applovinmax_placement_interstitial_no_ecpm = $request->applovinmax_placement_interstitial_no_ecpm;
        $applovinmax_placement_rewards_no_ecpm = $request->applovinmax_placement_rewards_no_ecpm;

        $applovinmax_placement_banner = $request->applovinmax_placement_banner;
        $applovinmax_placement_native = $request->applovinmax_placement_native;
        $applovinmax_placement_interstitial = $request->applovinmax_placement_interstitial;
        $applovinmax_placement_rewards = $request->applovinmax_placement_rewards;

        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->applovinmax_app_id_or_sdk_key = $applovinmax_app_id_or_sdk_key;
        
        $mBaseApplication->applovinmax_placement_banner_no_ecpm = $applovinmax_placement_banner_no_ecpm;
        $mBaseApplication->applovinmax_placement_native_no_ecpm = $applovinmax_placement_native_no_ecpm;
        $mBaseApplication->applovinmax_placement_interstitial_no_ecpm = $applovinmax_placement_interstitial_no_ecpm;
        $mBaseApplication->applovinmax_placement_rewards_no_ecpm = $applovinmax_placement_rewards_no_ecpm;

        $mBaseApplication->applovinmax_placement_banner = $applovinmax_placement_banner;
        $mBaseApplication->applovinmax_placement_native = $applovinmax_placement_native;
        $mBaseApplication->applovinmax_placement_interstitial = $applovinmax_placement_interstitial;
        $mBaseApplication->applovinmax_placement_rewards = $applovinmax_placement_rewards;
        
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }
    
    public function saveConfigAdsNewApplovinmax(Request $request) {
        $app_id = $request->app_id;

        $applovinmax_placement_new_banner_1 = $request->applovinmax_placement_new_banner_1;
        $applovinmax_placement_new_banner_2 = $request->applovinmax_placement_new_banner_2;
        $applovinmax_placement_new_banner_3 = $request->applovinmax_placement_new_banner_3;
        $applovinmax_placement_new_banner_4 = $request->applovinmax_placement_new_banner_4;
        $applovinmax_placement_new_banner_5 = $request->applovinmax_placement_new_banner_5;

        $applovinmax_placement_new_native_1 = $request->applovinmax_placement_new_native_1;
        $applovinmax_placement_new_native_2 = $request->applovinmax_placement_new_native_2;
        $applovinmax_placement_new_native_3 = $request->applovinmax_placement_new_native_3;
        $applovinmax_placement_new_native_4 = $request->applovinmax_placement_new_native_4;
        $applovinmax_placement_new_native_5 = $request->applovinmax_placement_new_native_5;

        $applovinmax_placement_new_interstitial_1 = $request->applovinmax_placement_new_interstitial_1;
        $applovinmax_placement_new_interstitial_2 = $request->applovinmax_placement_new_interstitial_2;
        $applovinmax_placement_new_interstitial_3 = $request->applovinmax_placement_new_interstitial_3;
        $applovinmax_placement_new_interstitial_4 = $request->applovinmax_placement_new_interstitial_4;
        $applovinmax_placement_new_interstitial_5 = $request->applovinmax_placement_new_interstitial_5;

        $applovinmax_placement_new_rewards_1 = $request->applovinmax_placement_new_rewards_1;
        $applovinmax_placement_new_rewards_2 = $request->applovinmax_placement_new_rewards_2;
        $applovinmax_placement_new_rewards_3 = $request->applovinmax_placement_new_rewards_3;
        $applovinmax_placement_new_rewards_4 = $request->applovinmax_placement_new_rewards_4;
        $applovinmax_placement_new_rewards_5 = $request->applovinmax_placement_new_rewards_5;


        $mBaseApplication = BaseApplication::findOrFail($app_id);
        
        $mBaseApplication->applovinmax_placement_new_banner_1 = $applovinmax_placement_new_banner_1;
        $mBaseApplication->applovinmax_placement_new_banner_2 = $applovinmax_placement_new_banner_2;
        $mBaseApplication->applovinmax_placement_new_banner_3 = $applovinmax_placement_new_banner_3;
        $mBaseApplication->applovinmax_placement_new_banner_4 = $applovinmax_placement_new_banner_4;
        $mBaseApplication->applovinmax_placement_new_banner_5 = $applovinmax_placement_new_banner_5;

        $mBaseApplication->applovinmax_placement_new_native_1 = $applovinmax_placement_new_native_1;
        $mBaseApplication->applovinmax_placement_new_native_2 = $applovinmax_placement_new_native_2;
        $mBaseApplication->applovinmax_placement_new_native_3 = $applovinmax_placement_new_native_3;
        $mBaseApplication->applovinmax_placement_new_native_4 = $applovinmax_placement_new_native_4;
        $mBaseApplication->applovinmax_placement_new_native_5 = $applovinmax_placement_new_native_5;

        $mBaseApplication->applovinmax_placement_new_interstitial_1 = $applovinmax_placement_new_interstitial_1;
        $mBaseApplication->applovinmax_placement_new_interstitial_2 = $applovinmax_placement_new_interstitial_2;
        $mBaseApplication->applovinmax_placement_new_interstitial_3 = $applovinmax_placement_new_interstitial_3;
        $mBaseApplication->applovinmax_placement_new_interstitial_4 = $applovinmax_placement_new_interstitial_4;
        $mBaseApplication->applovinmax_placement_new_interstitial_5 = $applovinmax_placement_new_interstitial_5;

        $mBaseApplication->applovinmax_placement_new_rewards_1 = $applovinmax_placement_new_rewards_1;
        $mBaseApplication->applovinmax_placement_new_rewards_2 = $applovinmax_placement_new_rewards_2;
        $mBaseApplication->applovinmax_placement_new_rewards_3 = $applovinmax_placement_new_rewards_3;
        $mBaseApplication->applovinmax_placement_new_rewards_4 = $applovinmax_placement_new_rewards_4;
        $mBaseApplication->applovinmax_placement_new_rewards_5 = $applovinmax_placement_new_rewards_5;
        
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveConfigAdsYandex(Request $request) {
        $app_id = $request->app_id;
        $yandex_app_id_or_sdk_key = $request->yandex_app_id_or_sdk_key;
        $yandex_placement_banner = $request->yandex_placement_banner;
        $yandex_placement_native = $request->yandex_placement_native;
        $yandex_placement_interstitial = $request->yandex_placement_interstitial;
        $yandex_placement_rewards = $request->yandex_placement_rewards;

        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->yandex_app_id_or_sdk_key = $yandex_app_id_or_sdk_key;
        $mBaseApplication->yandex_placement_banner = $yandex_placement_banner;
        $mBaseApplication->yandex_placement_native = $yandex_placement_native;
        $mBaseApplication->yandex_placement_interstitial = $yandex_placement_interstitial;
        $mBaseApplication->yandex_placement_rewards = $yandex_placement_rewards;
        
        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
    }

    public function saveMenuSettings(Request $request) {
        $app_id = $request->app_id;
        $settings_validation_device_api = $request->settings_validation_device_api;
        $settings_completed_option = $request->settings_completed_option;
        $settings_fifty_fifty = $request->settings_fifty_fifty;
        $settings_video_reward = $request->settings_video_reward;
        $settings_menu_dana_kaget = $request->settings_menu_dana_kaget;
        $settings_menu_badge_player = $request->settings_menu_badge_player;
        $settings_currency = $request->settings_currency;
        $settings_min_to_withdraw = $request->settings_min_to_withdraw;
        $settings_conversion_rate = $request->settings_conversion_rate;
        $settings_question_time = $request->settings_question_time;
        $settings_referral_register_points = $request->settings_referral_register_points;
        $settings_commission_withdraw_player_value = $request->settings_commission_withdraw_player_value;
        $settings_with_double_option_value = $request->settings_with_double_option_value;
        $settings_menu_rewards_point = $request->settings_menu_rewards_point;
        $settings_checking_emulator = $request->settings_checking_emulator;
        $settings_difference_ms_quiz = $request->settings_difference_ms_quiz;
        $settings_date_all_completed = $request->settings_date_all_completed;
        $settings_minimum_ad_withdraw = $request->settings_minimum_ad_withdraw;
        

        $mBaseApplication = BaseApplication::findOrFail($app_id);
        $mBaseApplication->settings_validation_device_api = $settings_validation_device_api;
        $mBaseApplication->settings_checking_emulator = $settings_checking_emulator;
        $mBaseApplication->settings_completed_option = $settings_completed_option;
        $mBaseApplication->settings_fifty_fifty = $settings_fifty_fifty;
        $mBaseApplication->settings_video_reward = $settings_video_reward;
        $mBaseApplication->settings_menu_dana_kaget = $settings_menu_dana_kaget;
        $mBaseApplication->settings_menu_badge_player = $settings_menu_badge_player;
        $mBaseApplication->settings_menu_rewards_point = $settings_menu_rewards_point;
        $mBaseApplication->settings_currency = $settings_currency;
        $mBaseApplication->settings_min_to_withdraw = $settings_min_to_withdraw;
        $mBaseApplication->settings_conversion_rate = $settings_conversion_rate;
        $mBaseApplication->settings_question_time = $settings_question_time;
        $mBaseApplication->settings_referral_register_points = $settings_referral_register_points;
        $mBaseApplication->settings_commission_withdraw_player_value = $settings_commission_withdraw_player_value;
        $mBaseApplication->settings_with_double_option_value = $settings_with_double_option_value;
        $mBaseApplication->settings_date_all_completed = $settings_date_all_completed;
        $mBaseApplication->settings_minimum_ad_withdraw = $settings_minimum_ad_withdraw;
        $mBaseApplication->settings_difference_ms_quiz = $settings_difference_ms_quiz;


        $mBaseApplication->save();
        if ($mBaseApplication) {
            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } else {
            return response()->json(['message' => 'Data gagal disimpan'], 500);
        }
        
    }
    // ENDINNERVIEW

}
