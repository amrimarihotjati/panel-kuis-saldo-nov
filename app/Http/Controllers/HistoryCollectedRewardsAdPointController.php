<?php

namespace App\Http\Controllers;

use App\Models\HistoryCollectedRewardsAdPoint;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class HistoryCollectedRewardsAdPointController extends Controller
{
    public function getDTHistoryCollectedRewardsAdPoint($app_pkg)
    {
        $query = HistoryCollectedRewardsAdPoint::query()
        ->with('player')
        ->with('rewardsAdPoints')
        ->where('player_pkg', $app_pkg);
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

    public function getCountHistoryCollectedRewardsAdPoint(Request $request)
    {
        $data = HistoryCollectedRewardsAdPoint::select('*')
        ->get();
        return $data->count();
    }
}
