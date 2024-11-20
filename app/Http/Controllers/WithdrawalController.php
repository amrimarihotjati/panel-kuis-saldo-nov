<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\BaseApplication;
use App\Models\Player;
use App\Models\RefferalPlayer;
use App\Models\PaymentMethod;
use App\Models\HistoryCollectedPoint;
use App\Models\CompletedArticlePoint;
use App\Models\RewardsAdPoints;
use App\Models\HistoryQuiz;
use App\Models\AdsCounterTemporary;
use App\Models\QuizCompleted;
use App\Models\BlacklistNumberWallet;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Mail;

class WithdrawalController extends Controller
{
    public function getDTWithdrawal($app_pkg)
    {
        $query = Withdrawal::query()
        ->with('player')
        ->with('paymentMethod')
        ->where('player_pkg', $app_pkg);

        return Datatables::eloquent($query)
        ->addColumn('big_point_quiz', function ($withdrawal) {
            $highestPoints = HistoryQuiz::where('player_id', $withdrawal->player_id)
            ->max('points');
            return $highestPoints;
        })
        ->addColumn('withdraw_count', function ($withdrawal) {
            return Withdrawal::where('player_id', $withdrawal->player_id)->count();
        })
        ->addColumn('withdraw_count_by_nomor', function ($withdrawal) {
            return Withdrawal::where('payment_account', $withdrawal->payment_account)->count();
        })
        ->addColumn('ad_inters_count', function ($withdrawal) {
            $completedArticleInters = CompletedArticlePoint::query()->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_inters_is_exist');

            $historyQuizInters = HistoryQuiz::query()->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_inters');

            return $completedArticleInters + $historyQuizInters;
        })
        ->addColumn('ad_rewards_count', function ($withdrawal) {
            $completedArticleRewards = CompletedArticlePoint::query()->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_rewards_is_exist');

            $historyQuizRewards = HistoryQuiz::query()->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_rewards');

            // $rewardsAdPointRewards = RewardsAdPoints::where('player_id', $withdrawal->player_id)
            // ->whereBetween('created_at', [now()->subDays(3), now()])
            // ->sum('watch_ads_value');

            return $historyQuizRewards + $completedArticleRewards;
        })
        ->filter(function ($query) use ($app_pkg) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];

                $query->whereHas('player', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });

                $query->where('player_pkg', $app_pkg);
            }

            if (request()->has('payment_method') && request()->get('payment_method') != '') {
                $paymentMethod = request()->get('payment_method');
                $query->whereHas('paymentMethod', function ($q) use ($paymentMethod) {
                    $q->where('method', $paymentMethod);
                });
            }

            if (request()->has('withdraw_count_by_nomor') && request()->get('withdraw_count_by_nomor') != '') {
                $withdrawCountByNomor = request()->get('withdraw_count_by_nomor');
                if (is_numeric($withdrawCountByNomor)) {
                    $query->whereIn('payment_account', function ($subQuery) use ($withdrawCountByNomor) {
                        $subQuery->select('payment_account')
                                  ->from('withdrawals')
                                  ->groupBy('payment_account')
                                  ->havingRaw('COUNT(*) = ?', [$withdrawCountByNomor]);
                    });
                }
            }
            
        })
        ->toJson();
    }

    public function getDTWithdrawalAllPkg()
    {
        $query = Withdrawal::query()
        ->with('player')
        ->with('paymentMethod')
        ->where('status', 0);

        return DataTables::eloquent($query)
        ->addColumn('big_point_quiz', function ($withdrawal) {
            $highestPoints = HistoryQuiz::where('player_id', $withdrawal->player_id)
            ->max('points');
            return $highestPoints;
        })
        ->addColumn('withdraw_count', function ($withdrawal) {
            return Withdrawal::where('player_id', $withdrawal->player_id)->count();
        })
        ->addColumn('withdraw_count_by_nomor', function ($withdrawal) {
            return Withdrawal::where('payment_account', $withdrawal->payment_account)->count();
        })
        ->addColumn('ad_inters_count', function ($withdrawal) {
            $completedArticleInters = CompletedArticlePoint::query()
            ->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_inters_is_exist');

            $historyQuizInters = HistoryQuiz::query()
            ->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_inters');

            return $completedArticleInters + $historyQuizInters;
        })
        ->addColumn('ad_rewards_count', function ($withdrawal) {
            $completedArticleRewards = CompletedArticlePoint::query()
            ->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_rewards_is_exist');

            $historyQuizRewards = HistoryQuiz::query()
            ->where('player_id', $withdrawal->player_id)
            ->whereBetween('created_at', [now()->subDays(3), now()])
            ->sum('ads_watched_rewards');

            return $historyQuizRewards + $completedArticleRewards;
        })
        ->filter(function ($query) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];

                $query->whereHas('player', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
            }

            if (request()->has('payment_method') && request()->get('payment_method') != '') {
                $paymentMethod = request()->get('payment_method');
                $query->whereHas('paymentMethod', function ($q) use ($paymentMethod) {
                    $q->where('method', $paymentMethod);
                });
            }

            if (request()->has('withdraw_count_by_nomor') && request()->get('withdraw_count_by_nomor') != '') {
                $withdrawCountByNomor = request()->get('withdraw_count_by_nomor');
                if (is_numeric($withdrawCountByNomor)) {
                    $query->whereIn('payment_account', function ($subQuery) use ($withdrawCountByNomor) {
                        $subQuery->select('payment_account')
                                  ->from('withdrawals')
                                  ->groupBy('payment_account')
                                  ->havingRaw('COUNT(*) = ?', [$withdrawCountByNomor]);
                    });
                }
            }
            
        })
        ->toJson();
    }

    public function getDTWithdrawalRange($app_pkg, $startDate, $endDate)
    {
        $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

        $appPackages = explode(',', $app_pkg);

        $query = Withdrawal::query()
        ->with('player')
        ->with('paymentMethod')
        ->where('status', 1)
        ->whereIn('player_pkg', $appPackages)
        ->whereBetween('created_at', [$startDate, $endDate]);

        return Datatables::eloquent($query)
        ->filter(function ($query) use ($appPackages) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];
                $query->whereHas('player', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
                $query->whereIn('player_pkg', $appPackages);
            }
        })
        ->toJson();
    }

    public function getCountWithdrawal(Request $request)
    {
        $data = Withdrawal::select('*')->orderBy('created_at', 'desc')->get();
        return $data->count();
    }

    public function updateStatusWithdrawalRequest(Request $request)
    {
        $mWithdrawal = Withdrawal::findOrFail($request->withdrawal_id);
        $mPlayer = Player::where('id', $request->player_id)->first();
        $mBaseApplication = BaseApplication::where('app_pkg', $request->app_id)->first();

        $responWithdrawalStatus = $request->status;
        $responWithdrawalMessage = $request->payment_message;
        $responWithdrawalPoints = $request->withdrawal_points;
        $responWithdrawalAmounts = $request->withdrawal_amount;

        $responWithdrawalResetAds = $request->with_reset_ads ?? 0;
        $responWithdrawalResetCompletedArticle = $request->with_reset_completed_article ?? 0;
        $responWithdrawalResetCompletedQuiz = $request->with_reset_completed_quiz ?? 0;


        $mPlayerPoints = $mPlayer->points;
        $minimumWithdraw = $mBaseApplication->settings_min_to_withdraw;

        if ($responWithdrawalPoints < $minimumWithdraw) {
            return redirect()
            ->back()
            ->with('status', 'Jumlah penarikan tidak dilakukan karena points kurang dari persyaratan minimum penarikan points ' . $minimumWithdraw);
        }

        $mWithdrawal->status = $responWithdrawalStatus;
        $mWithdrawal->payment_message = $responWithdrawalMessage;
        $mWithdrawal->save();

        $mPaymentMethod = PaymentMethod::where('id', $mWithdrawal->payment_method)->first();

        if ($mWithdrawal) {
            if ($responWithdrawalStatus == 1) {
                $mBlacklistNumberWallet = BlacklistNumberWallet::where('number_wallet', $mWithdrawal->payment_account)->first();
                if ($mBlacklistNumberWallet) {
                    return response()->json(['message' => 'TIDAK DAPAT DISETUJUI, NOMOR AKUN INI MASUK DALAM BLACKLIST!!'], 500);
                }
                $playerGetBonusCommission = RefferalPlayer::where('refferaled_registered_player', $mPlayer->id)
                ->where('player_pkg', $mPlayer->player_pkg)
                ->first();
                if (!is_null($playerGetBonusCommission)) {
                    $addedCommisionPlayer = Player::where('id', $playerGetBonusCommission->refferaled_from_player)->first();
                    if (!is_null($addedCommisionPlayer)) {
                        $mCreateHistoryCollectedPoint = HistoryCollectedPoint::create([
                            'player_id' => $playerGetBonusCommission->refferaled_from_player,
                            'point_collected_from' => 'app-quiz:' . $mBaseApplication->app_pkg,
                            'point_collected_value' => $mBaseApplication->settings_commission_withdraw_player_value,
                            'description' => 'Added commision withdraw point from Refferaled',
                            'player_pkg' => $playerGetBonusCommission->player_pkg,
                        ]);

                        $addedCommisionPlayer->points += $mBaseApplication->settings_commission_withdraw_player_value;
                        $addedCommisionPlayer->points_collected += $mBaseApplication->settings_commission_withdraw_player_value;
                        $addedCommisionPlayer->save();
                    }
                }

                try {
                    Mail::send('layouts.verification.withdraw.payment-accepted',
                        [
                            'name' => $mPlayer->name,
                            'points' => $responWithdrawalPoints,
                            'amount' => $responWithdrawalAmounts,
                            'account_number' => $mWithdrawal->payment_account,
                            'payment_method' => $mPaymentMethod->method,
                        ],
                        function ($message) use ($mPlayer) {
                            $message->to($mPlayer->email);
                            $message->subject('WITHDRAWAL DISETUJUI');
                        });
                } catch (\Exception $e) {
                }


            }
            if ($responWithdrawalResetAds == 1) {
                $dataAdsTemporary = AdsCounterTemporary::where('player_id', $mPlayer->id)->get();
                foreach ($dataAdsTemporary as $adsTemporary) {
                    $adsTemporary->delete();
                }
            }

            if ($responWithdrawalResetCompletedArticle == 1) {
                $dataCompletedArticleTemporary = CompletedArticlePoint::where('player_id', $mPlayer->id)->get();
                foreach ($dataCompletedArticleTemporary as $completedArticleTemporary) {
                    $completedArticleTemporary->delete();
                }
            }

            if ($responWithdrawalResetCompletedQuiz == 1) {
                $dataCompletedArticleQuiz = QuizCompleted::where('player_id', $mPlayer->id)->get();
                foreach ($dataCompletedArticleQuiz as $completedArticleQuiz) {
                    $completedArticleQuiz->delete();
                }
            }

            return response()->json(['message' => 'EDIT RESPONSE PAYMENT SUCCESSS!!'], 200);
        } else {
            return response()->json(['message' => 'EDIT RESPONSE PAYMENT FAILED!!'], 500);
        }
    }
}
