<?php

namespace App\Http\Controllers;

use App\Models\HistoryExchangeBadgePlayer;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class HistoryExchangeBadgePlayerController extends Controller
{
    public function getDTHistoryExchangeBadge($app_pkg)
    {
        $query = HistoryExchangeBadgePlayer::query()
        ->with('player')
        ->with('badge')
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

    public function getCountHistoryExchangeBadge(Request $request)
    {
        $data = HistoryExchangeBadgePlayer::select('*')
        ->get();
        return $data->count();
    }
}
