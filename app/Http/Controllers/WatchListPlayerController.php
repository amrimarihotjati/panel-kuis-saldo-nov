<?php

namespace App\Http\Controllers;

use App\Models\WatchListPlayer;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class WatchListPlayerController extends Controller
{
    public function getDTWatchListPlayer($app_pkg)
    {
        $query = WatchListPlayer::query()
        ->with('player')
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

    public function removePlayerFromWatchList($player_id)
    {
        $mPlayer = WatchListPlayer::where('player_id', $player_id)->first();
        if ($mPlayer) {
            $mPlayer->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

}
