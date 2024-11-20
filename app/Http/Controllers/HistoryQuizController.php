<?php

namespace App\Http\Controllers;

use App\Models\HistoryQuiz;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;


class HistoryQuizController extends Controller
{
    public function getDTHistoryQuiz($app_pkg)
    {
        $query = HistoryQuiz::query()
        ->with('player')
        ->with('categoryQuiz')
        ->where('player_pkg', $app_pkg);
        return Datatables::eloquent($query)->filter(function ($query) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];
                $query->whereHas('player', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
            }
        })->toJson();
    }

    public function getDTHistoryQuizRange($app_pkg, $startDate, $endDate)
    {

        $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

        $query = HistoryQuiz::query()
        ->with('player')
        ->with('categoryQuiz')
        ->where('player_pkg', $app_pkg)
        ->whereBetween('created_at', [$startDate, $endDate]);

        return Datatables::eloquent($query)->filter(function ($query) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];
                $query->whereHas('player', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
            }
        })->toJson();
    }

    public function getDTHistoryQuizRangeActivity($app_pkg, $startDate, $endDate) {
        $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

        $query = HistoryQuiz::query()
        ->with('player')
        ->where('player_pkg', $app_pkg)
        ->whereBetween('created_at', [$startDate, $endDate])
        ->select('player_id', 
           \DB::raw('COUNT(*) as total_bermain_kuis'),
           \DB::raw('SUM(points) as total_point_collected'),
           \DB::raw('SUM(ads_watched_inters) as total_ads_inters'),
           \DB::raw('SUM(ads_watched_rewards) as total_ads_rewards'))
        ->groupBy('player_id');

        return Datatables::eloquent($query)->filter(function ($query) use ($app_pkg) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];
                $query->whereHas('player', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
                $query->where('player_pkg', $app_pkg);
            }
        })->toJson();
    }





    public function getCountHistoryQuiz(Request $request)
    {
        $data = HistoryQuiz::select('*')
        ->get();
        return $data->count();
    }
}
