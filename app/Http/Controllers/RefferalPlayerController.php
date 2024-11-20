<?php

namespace App\Http\Controllers;

use App\Models\RefferalPlayer;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class RefferalPlayerController extends Controller
{
    public function getDTRefferalPlayer($app_pkg)
    {
        $query = RefferalPlayer::query()->with(['registeredPlayer', 'fromPlayer'])->where('player_pkg', $app_pkg);
        return Datatables::eloquent($query)->filter(function ($query) use ($app_pkg) {
            if (request()->has('search')) {
                $search = request()->get('search')['value'];
                $query->whereHas('registeredPlayer', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                })->orWhereHas('fromPlayer', function ($q2) use ($search) {
                    $q2->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
                });
                $query->where('player_pkg', $app_pkg);
            }
        })->toJson();
    }


    public function getCountRefferalPlayer(Request $request)
    {
        $data = RefferalPlayer::select('*')
        ->get();
        return $data->count();
    }
}
