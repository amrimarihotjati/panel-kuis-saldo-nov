<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Badge;
use App\Models\HistoryCollectedPoint;
use App\Models\HistoryCollectedRewardsAdPoint;
use App\Models\HistoryExchangeBadgePlayer;
use App\Models\Withdrawal;
use App\Models\HistoryQuiz;
use App\Models\BaseApplication;
use App\Models\CategoryQuiz;
use App\Models\QuizCompleted;
use App\Models\Question;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class PlayerController extends Controller
{
    public function getDTPlayer($app_pkg)
    {
        $query = Player::query()->where('player_pkg', $app_pkg);
        return Datatables::eloquent($query)->filter(function ($query) use ($app_pkg) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
                $query->where('player_pkg', $app_pkg);
            }
        })->toJson();
    }


    public function getDTPantauPlayer($app_pkg)
    {
        $query = Player::query()
        ->with('withdrawals')
        ->with('withdrawals.paymentMethod')
        ->where('player_pkg', $app_pkg);
        return Datatables::eloquent($query)->filter(function ($query) use ($app_pkg) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
                $query->where('player_pkg', $app_pkg);
            }
        })->toJson();
    }

    public function getCountPlayer(Request $request)
    {
        $data = Player::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }
    
    public function getDTPantauPrivateCollectedPointPlayer($player_id)
    {
        $query = HistoryCollectedPoint::query()
        ->with('player')
        ->where('player_id', $player_id);
        return Datatables::eloquent($query)->toJson();
    }

    public function goPantauPrivateCollectedPointPlayer($player_id)
    {
        $mPlayer = Player::where('id', $player_id)->first();
        return view('layouts/page/detail/new-pantau-collected-point', compact('mPlayer'));
    }

    public function getDataStatisticPlayer($player_id)
    {
        $mPlayer = Player::where('id', $player_id)->first();

        $mHistoryCollectedRewardsAdPoint = HistoryCollectedRewardsAdPoint::where('player_id', $player_id)->count();
        $mHistoryQuiz = HistoryQuiz::where('player_id', $player_id)->count();

        $mAdTrafficInters = HistoryCollectedPoint::where('player_id', $player_id)
        ->get()
        ->sum('ads_watched_inters_is_exist');
        $mAdTrafficRewards = HistoryCollectedPoint::where('player_id', $player_id)
        ->get()
        ->sum('ads_watched_rewards_is_exist');

        $mWithdrawalCount = Withdrawal::where('player_id', $player_id)
        ->count();
        $mWithdrawalPending = Withdrawal::where('player_id', $player_id)
        ->where('status', 0)
        ->count();
        $mWithdrawalAccepted = Withdrawal::where('player_id', $player_id)
        ->where('status', 1)
        ->count();
        $mWithdrawalDenied = Withdrawal::where('player_id', $player_id)
        ->where('status', 2)
        ->count();

        $mWithdrawalPointTotal = Withdrawal::where('player_id', $player_id)->sum('points');
        $mWithdrawalAmountTotal = Withdrawal::where('player_id', $player_id)->sum('amount');

        $mWithdrawalLastDeniedMsg = Withdrawal::where('player_id', $player_id)
        ->where('status', 2)
        ->orderBy('created_at', 'desc')
        ->first();

        $data = [
            'player' => $mPlayer,
            'collected_rewards_ad_point' => $mHistoryCollectedRewardsAdPoint,
            'quiz_participation' => $mHistoryQuiz,
            'ad_inters_count' => $mAdTrafficInters,
            'ad_rewards_count' => $mAdTrafficRewards,
            'withdrawal' => [
                'count' => $mWithdrawalCount,
                'pending' => $mWithdrawalPending,
                'accepted' => $mWithdrawalAccepted,
                'denied' => $mWithdrawalDenied,
                'total_points' => $mWithdrawalPointTotal,
                'total_amount' => $mWithdrawalAmountTotal,
                'last_denied_message' => $mWithdrawalLastDeniedMsg ? $mWithdrawalLastDeniedMsg->payment_message : null,
            ]
        ];

        return response()->json($data);
    }

    public function getDataQuizCompletedStatistic($player_id) {
        $mPlayer = Player::where('id', $player_id)->first();
        $baseApplication = BaseApplication::where('app_pkg', $mPlayer->player_pkg)->first();

        $categoryQuizIds = is_string($baseApplication->category_quiz) 
        ? json_decode($baseApplication->category_quiz, true) 
        : $baseApplication->category_quiz;

        if (!is_array($categoryQuizIds)) {
            return response()->json(['error' => 'Invalid category data'], 400);
        }

        $categories = CategoryQuiz::whereIn('id', $categoryQuizIds)
        ->orderBy('category_name', 'asc')
        ->get();

        $data = [];
        $totalCompleted = 0; 
        $totalNotCompleted = 0;

        foreach ($categories as $category) {
            $levels = Question::where('category_id', $category->id)
            ->select('level')
            ->distinct()
            ->orderBy('level', 'asc')
            ->get();

            $completedLevels = QuizCompleted::where('player_id', $mPlayer->id)
            ->where('category_id', $category->id)
            ->get();

            foreach ($levels as $level) {
                $completedEntry = $completedLevels->firstWhere('category_level', $level->level);
                $isCompleted = $completedEntry !== null;
                $createdAt = $isCompleted ? $completedEntry->created_at : null;

                $data[] = [
                    '#' => '',
                    'player' => $mPlayer,
                    'category' => $category,
                    'level' => $level->level,
                    'status' => $isCompleted ? 'SELESAI' : 'BELUM',
                    'waktu' => $createdAt
                ];

                if ($isCompleted) {
                    $totalCompleted++;
                } else {
                    $totalNotCompleted++;
                }
            }
        }

        return response()->json([
            'data' => $data,
            'total_completed' => $totalCompleted,
            'total_not_completed' => $totalNotCompleted
        ]);
    }

    public function getDtPantauHistoryQuiz($player_id) {
        $mPlayer = Player::where('id', $player_id)->first();
        $baseApplication = BaseApplication::where('app_pkg', $mPlayer->player_pkg)->first();

        $doublePoint = $baseApplication->settings_with_double_option_value ?? 0;

        $query = HistoryQuiz::query()
        ->with('player')
        ->with('categoryQuiz')
        ->where('player_pkg', $mPlayer->player_pkg)
        ->where('player_id', $mPlayer->id);

        return Datatables::eloquent($query)
        ->addColumn('doublePoint', function($row) use ($doublePoint) {
            return $row->points * ($doublePoint / 100);
        })
        ->addColumn('totalPointFromQuestionCategory', function($row) {
            $totalPointFromLevel = Question::where('category_id', $row->category_id)
            ->where('level', $row->category_level)
            ->sum('points');

            return $totalPointFromLevel;
        })
        ->toJson();

    }

    public function resetAllCompletedQuizFromPlayer(Request $request)
    {
        $player_id = $request->player_id;
        $dataCompletedQuiz = QuizCompleted::where('player_id', $player_id)->get();
        if ($dataCompletedQuiz->isEmpty()) {
            return response()->json(['message' => 'Completed quiz kosong'], 500);
        }
        foreach ($dataCompletedQuiz as $mCompletedQuiz) {
            $mCompletedQuiz->delete();
        }
        return response()->json(['message' => 'Completed quiz data berhasil dihapus'], 200);
    }


    public function createPlayer(Request $request)
    {
        $player_name = $request->name;
        $player_email = $request->email;
        $player_points = $request->points;
        $player_score = $request->score;
        $player_password = $request->password;
        $player_player_pkg = $request->app_pkg;
        $player_real_player = 1;

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $player_refferal_code = $randomString;

        if (Player::where('referral_code', $player_refferal_code)->exists()) {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $randomString = '';
            for ($i = 0; $i < 16; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $player_refferal_code = $randomString;
        }

        if ($cekPlayerEmail = Player::where('email', $player_email)->where('player_pkg', $player_player_pkg)->exists()) {
            return response()->json(['message' => 'Player dengan email ini sudah ada'], 500);
        }

        $mPlayer = Player::create([
            'name' => $player_name,
            'email' => $player_email,
            'score' => $player_score,
            'points' => $player_points,
            'points_collected' => $player_points,
            'referral_code' => $player_refferal_code,
            'password' => bcrypt($player_password),
            'player_pkg' => $player_player_pkg,
            'real_player' => $player_real_player,
        ]);

        if ($mPlayer) {
            return response()->json(['message' => 'Player berhasil dibuat'], 200);
        } else {
            return response()->json(['message' => 'Player gagal dibuat'], 500);
        }
    }

    public function editPlayer(Request $request) {
        $mPlayer = Player::findOrFail($request->player_id);
        
        $playerName = $request->name;
        $playerToken = $request->token;
        $playerScore = $request->score;
        $playerPoints = $request->points;
        $playerPointsCollected = $request->points_collected;
        $playerDeviceName = $request->device_name;
        $playerDeviceId = $request->device_id;
        $playerRealPlayer = $request->real_player;
        $playerStatus = $request->status;

        $mPlayer->name = $playerName;
        $mPlayer->token = $playerToken;
        $mPlayer->score = $playerScore;
        $mPlayer->points = $playerPoints;
        $mPlayer->points_collected = $playerPointsCollected;
        $mPlayer->device_name = $playerDeviceName;
        $mPlayer->device_id = $playerDeviceId;
        $mPlayer->real_player = $playerRealPlayer;
        $mPlayer->status = $playerStatus;
        $mPlayer->save();

        if ($mPlayer) {
            return response()->json(['message' => 'Data Player berhasil diubah'], 200);
        } else {
            return response()->json(['message' => 'Data Player gagal diubah'], 500);
        }
    }

    public function forceEditPasswordPlayer(Request $request) {
        $mPlayer = Player::findOrFail($request->player_id);
        $player_password = $request->player_password;
        $mPlayer->password = bcrypt($player_password);
        $mPlayer->save();

        if ($mPlayer) {
            return response()->json(['message' => 'Password Player berhasil diubah'], 200);
        } else {
            return response()->json(['message' => 'Password Player gagal diubah'], 500);
        }
    }

    public function detailPlayer($id) {
        $mPlayer = Player::findOrFail($id);
        $mBadgePrimary = Badge::where('id', $mPlayer->badge_primary)->first();

        $badgeListPublic = Badge::where('badge_level', '!=', 1)
        ->orderBy('badge_level', 'asc')
        ->get();

        $badgesOnPlayer = HistoryExchangeBadgePlayer::where('player_id', $mPlayer->id)
        ->get();
        $badgeCounts = $badgesOnPlayer->groupBy('badge_id')->map(function ($group) {
            return $group->count();
        });
        $badgeIds = $badgeCounts->keys();
        $mBadgeListWithCount = Badge::whereIn('id', $badgeIds)->get()->map(function ($badge) use ($badgeCounts) {
            $badge->count = $badgeCounts[$badge->id];
            return $badge;
        });

        return view('layouts/page/edit/edit-player', compact('mPlayer', 'mBadgePrimary', 'mBadgeListWithCount', 'badgeListPublic'));
    }

    public function giftPoint(Request $request) {
        $player_id = $request->player_id;
        $gift_point = $request->gift_point;

        if (is_null($player_id) || is_null($gift_point)) {
            return response()->json(['message' => 'Data diperlukan'], 500);
        }

        $mPlayer = Player::findOrFail($player_id);
        $mPlayer->points += $gift_point;
        $mPlayer->save();

        if ($mPlayer) {
            $mCreateHistoryCollectedPoint = HistoryCollectedPoint::create([
                'player_id' => $mPlayer->id,
                'point_collected_from' => 'bonus:admin',
                'point_collected_value' => $gift_point,
                'description' => 'Bonus gift points from admin',
                'player_pkg' => $mPlayer->player_pkg
            ]);
            return response()->json(['message' => 'Point berhasil diberikan ke player'], 200);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function giftBadge(Request $request) {
        $player_id = $request->player_id;
        $badge_id = $request->badge_id;

        if (is_null($player_id) || is_null($badge_id)) {
            return response()->json(['message' => 'Data diperlukan'], 500);
        }

        $badgeSelected = Badge::find($badge_id);

        if (is_null($badgeSelected)) {
            return ApiFormatter::createApiFailed('Badge yang dipilih tidak tersedia');
        }

        $mPlayer = Player::findOrFail($player_id);

        if (is_null($mPlayer)) {
            return ApiFormatter::createApiFailed('Player tidak ditemukan');
        }

        $mHistoryExchangeBadgePlayer = HistoryExchangeBadgePlayer::create([
            'player_id' => $mPlayer->id,
            'badge_id' => $badgeSelected->id,
            'player_pkg' => $mPlayer->player_pkg
        ]);

        if ($mHistoryExchangeBadgePlayer) {
            $mPlayer->badge_primary = $badgeSelected->id;
            $mPlayer->save();
            return response()->json(['message' => 'Badge berhasil diberikan ke player'], 200);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function deletePlayer($id) {
        $mPlayer = Player::findOrFail($id);
        $mPlayer->delete();
        if ($mPlayer) {
           return redirect('/base-application');
       } else {
           return response()->json(['message' => 'Player gagal dihapus'], 500);
       }
   }

}
