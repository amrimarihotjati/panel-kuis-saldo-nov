<?php

namespace App\Http\Controllers;

use App\Models\CompletedArticlePoint;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class CompletedArticlePointController extends Controller
{
    public function getDTCompletedArticlePoint(Request $request)
    {
        $app_pkg = $request->app_pkg;
        $query = CompletedArticlePoint::query()
        ->where('player_pkg', $app_pkg)
        ->with('player')
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

    public function getCountCompletedArticlePoint(Request $request)
    {
        $data = CompletedArticlePoint::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function resetAllCompletedArticlePointFromPackage(Request $request)
    {
        $app_pkg = $request->app_pkg;
        $dataArticlePointCompleted = CompletedArticlePoint::where('player_pkg', $app_pkg)->get();
        if ($dataArticlePointCompleted->isEmpty()) {
            return response()->json(['message' => 'Completed Article kosong'], 500);
        }
        foreach ($dataArticlePointCompleted as $articleCompleted) {
            $articleCompleted->delete();
        }
        return response()->json(['message' => 'Completed Article Berhasil direset'], 200);
    }
}
