<?php

namespace App\Http\Controllers;

use App\Models\HistoryCollectedPoint;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class HistoryCollectedPointController extends Controller
{
     public function getDTCollectedPoint($app_pkg)
    {
        $query = HistoryCollectedPoint::query()
        ->with('player')
        ->where('player_pkg', $app_pkg);
        return Datatables::eloquent($query)->filter(function ($query) use ($app_pkg)  {
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

    public function getDTCollectedPointRange($app_pkg, $startDate, $endDate)
    {

        $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
        $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

        $query = HistoryCollectedPoint::query()
        ->with('player')
        ->where('player_pkg', $app_pkg)
        ->whereBetween('created_at', [$startDate, $endDate]);

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


    public function getCountHistoryCollectedPoint(Request $request)
    {
        $data = HistoryCollectedPoint::select('*')
        ->get();
        return $data->count();
    }
}
