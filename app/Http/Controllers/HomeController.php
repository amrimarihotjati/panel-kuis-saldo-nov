<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BaseApplication;
use App\Models\Daget;
use App\Models\Banner;
use App\Models\Avatar;
use App\Models\Badge;
use App\Models\CategoryQuiz;
use App\Models\RewardsAdPoints;

use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function goBaseApplication(Request $request)
    {
        return view('layouts/page/base-application-resources');
    }

    public function goBanner(Request $request)
    {
        return view('layouts/page/banner-resources');
    }

    public function goAvatar(Request $request)
    {
        return view('layouts/page/avatar-resources');
    }

    public function goBadge(Request $request)
    {
        return view('layouts/page/badge-resources');
    }

    public function goCategoryQuiz(Request $request)
    {
        return view('layouts/page/category-quiz-resources');
    }

    public function goDanaKaget(Request $request)
    {
        return view('layouts/page/daget-resources');
    }

    public function goRewardsAdPoints(Request $request)
    {
        return view('layouts/page/rewards-ad-points-resources');
    }

    public function goPaymentMethod(Request $request)
    {
        return view('layouts/page/payment-method-resources');
    }

    public function goBlacklistNumberWallet(Request $request)
    {
        return view('layouts/page/blacklist-number-wallet-method-resources');
    }


    // analyctics
    public function goAnalyticsCollectedPoint(Request $request)
    {
        $mBaseApplication = BaseApplication::all();
        return view('layouts/page/analytics/data-collected-point', compact('mBaseApplication'));
    }

    public function goAnalyticsHistoryQuiz(Request $request)
    {
        $mBaseApplication = BaseApplication::all();
        return view('layouts/page/analytics/data-history-quiz', compact('mBaseApplication'));
    }

    public function goAnalyticsPlayerActivity(Request $request)
    {
        $mBaseApplication = BaseApplication::all();
        return view('layouts/page/analytics/data-player-activity', compact('mBaseApplication'));
    }

    public function goAnalyticsWithdrawals(Request $request)
    {
        $mBaseApplication = BaseApplication::all();
        return view('layouts/page/analytics/data-withdrawals', compact('mBaseApplication'));
    }

    public function index(Request $request)
    {
        $appCount = BaseApplication::get()->count();
        $bannerCount = Banner::get()->count();
        $avatarCount = Avatar::get()->count();
        $badgeCount = Badge::get()->count();
        $categoryQuizCount = CategoryQuiz::get()->count();
        $dagetCount = Daget::get()->count();
        $rewardsAdPointCount = RewardsAdPoints::get()->count();

        return view('home', compact('appCount', 'bannerCount', 'avatarCount', 'badgeCount','categoryQuizCount', 'dagetCount', 'rewardsAdPointCount'));
    }

    public function blank()
    {
        return view('layouts.blank-page');
    }
}
