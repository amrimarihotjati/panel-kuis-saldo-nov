<?php

namespace App\Http\Controllers;

use App\Models\CompletedPointKaget;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class CompletedPointKagetController extends Controller
{
   public function getDTCompletedPointKaget(Request $request)
    {
        $app_pkg = $request->app_pkg;
        $query = CompletedPointKaget::query()
        ->where('player_pkg', $app_pkg)
        ->with('player')
        ->with('rewardsAdPoints')
        ->orderBy('created_at', 'desc');
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

    public function getCountCompletedPointKaget(Request $request)
    {
        $data = CompletedPointKaget::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function resetAllCompletedPointKagetFromPackage(Request $request)
    {
        $app_pkg = $request->app_pkg;
        $dataPointKagetCompleted = CompletedPointKaget::where('player_pkg', $app_pkg)->get();
        if ($dataPointKagetCompleted->isEmpty()) {
            return response()->json(['message' => 'Completed Point Kaget kosong'], 500);
        }
        foreach ($dataPointKagetCompleted as $articleCompleted) {
            $articleCompleted->delete();
        }
        return response()->json(['message' => 'Completed Point Kaget Berhasil direset'], 200);
    }
}
