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
use App\Models\Question;
use App\Models\AdsCounterTemporary;
use App\Models\QuizCompleted;
use App\Models\BlacklistNumberWallet;

use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Mail;

class DashboardWithdrawalController extends Controller
{

	public function getDatatableWithdrawAllMethodPending()
	{
		$query = Withdrawal::query()
		->with('player')
		->with('paymentMethod')
		->where('withdrawals.status', 0);

		return DataTables::of($query)->toJson();
	}

	public function getDatatableWithdrawDanaPending()
	{
		$query = Withdrawal::query()
		->with('player')
		->with('paymentMethod')
		->where('withdrawals.status', 0)
		->whereHas('paymentMethod', function ($q) {
			$q->where('method', 'Dana');
		});

		return DataTables::of($query)->toJson();
	}


	public function getDatatableWithdrawOvoPending()
	{
		$query = Withdrawal::query()
		->with('player')
		->with('paymentMethod')
		->where('withdrawals.status', 0)
		->whereHas('paymentMethod', function ($q) {
			$q->where('method', 'Ovo');
		});

		return DataTables::of($query)->toJson();
	}

	public function getDatatableWithdrawShoopepayPending()
	{
		$query = Withdrawal::query()
		->with('player')
		->with('paymentMethod')
		->where('withdrawals.status', 0)
		->whereHas('paymentMethod', function ($q) {
			$q->where('method', 'Shoopepay');
		});

		return DataTables::of($query)->toJson();
	}

	public function getDatatableWithdrawGopayPending()
	{
		$query = Withdrawal::query()
		->with('player')
		->with('paymentMethod')
		->where('withdrawals.status', 0)
		->whereHas('paymentMethod', function ($q) {
			$q->where('method', 'Gopay');
		});
		return DataTables::of($query)->toJson();
	}

	public function getDatatableWithdrawLinkajaPending()
	{
		$query = Withdrawal::query()
		->with('player')
		->with('paymentMethod')
		->where('withdrawals.status', 0)
		->whereHas('paymentMethod', function ($q) {
			$q->where('method', 'LinkAja');
		});
		return DataTables::of($query)->toJson();
	}

	public function getDataPlayerStatisticForWithdraw($withdrawalId)
	{
		$withdrawal = Withdrawal::where('id', $withdrawalId)->first();
		$countWdByAccount = Withdrawal::where('player_id', $withdrawal->player_id)->count();
		$countWdByNumber = Withdrawal::where('payment_account', $withdrawal->payment_account)->count();

		$completedArticleInters = CompletedArticlePoint::query()
		->where('player_id', $withdrawal->player_id)
		->whereBetween('created_at', [now()->subDays(3), now()])
		->sum('ads_watched_inters_is_exist');

		$historyQuizInters = HistoryQuiz::query()
		->where('player_id', $withdrawal->player_id)
		->whereBetween('created_at', [now()->subDays(3), now()])
		->sum('ads_watched_inters');

		$completedArticleRewards = CompletedArticlePoint::query()
		->where('player_id', $withdrawal->player_id)
		->whereBetween('created_at', [now()->subDays(3), now()])
		->sum('ads_watched_rewards_is_exist');

		$historyQuizRewards = HistoryQuiz::query()
		->where('player_id', $withdrawal->player_id)
		->whereBetween('created_at', [now()->subDays(3), now()])
		->sum('ads_watched_rewards');

		$totalIntersWatched3days = $completedArticleInters + $historyQuizInters;
		$totalRewardsWatched3days = $completedArticleRewards + $historyQuizRewards;

		$validCount = 0;
		$invalidCount = 0;

		$bigPointQuiz = HistoryQuiz::where('player_id', $withdrawal->player_id)
		->max('points');

		$historyQuiz = HistoryQuiz::where('player_id', $withdrawal->player_id)
		->orderBy('created_at', 'desc')
		->limit(50)
		->get();

		foreach ($historyQuiz as $quiz) {
			$totalPointFromQuestionCategory = Question::where('category_id', $quiz->category_id)
			->where('level', $quiz->category_level)
			->sum('points');
			$withDoubleOption = $quiz->with_double_option ?? 0;
			if ($withDoubleOption == 1) {
				if ($quiz->points > ($totalPointFromQuestionCategory + 300)) {
					$invalidCount++;
				} else {
					$validCount++;
				}
			} else {
				if ($quiz->points <= $totalPointFromQuestionCategory) {
					$validCount++;
				} else if ($quiz->points > $totalPointFromQuestionCategory) {
					$invalidCount++;
				} else {
					$validCount++;
				}
			}
		}

		return response()->json([
			'bigPointQuiz' => $bigPointQuiz,
			'validCountQuiz' => $validCount,
			'invalidCountQuiz' => $invalidCount,
			'totalIntersWatched3days' => $totalIntersWatched3days,
			'totalRewardsWatched3days' => $totalRewardsWatched3days,
			'countWdByNumber' => $countWdByNumber,
			'countWdByAccount' => $countWdByAccount
		]);
	}


}