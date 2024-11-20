<?php

namespace App\Http\Controllers;

use App\Models\RewardsAdPoints;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class RewardsAdPointsController extends Controller
{
    public function getDTRewardsAdPoints()
    {
        $query = RewardsAdPoints::query()->orderBy('point_number', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountRewardsAdPoints(Request $request)
    {
        $data = RewardsAdPoints::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

     public function createRewardsAdPoints(Request $request)
    {
        $title = $request->title;
        $time_claimed = $request->time_claimed;
        $watch_ads_value = $request->watch_ads_value;
        $point_value = $request->point_value;

        $mRewardsAdPoints = RewardsAdPoints::create([
            'title' => $title,
            'time_claimed' => $time_claimed,
            'watch_ads_value' => $watch_ads_value,
            'point_value' => $point_value
        ]);

        if ($mRewardsAdPoints) {
            return response()->json(['message' => 'RewardsAdPoints berhasil dibuat'], 200);
        } else {
           return response()->json(['message' => 'RewardsAdPoints gagal dibuat'], 500);
       }
    }

    public function editRewardsAdPoints(Request $request) {
        $findRewardsAdPoints = RewardsAdPoints::findOrFail($request->rewards_ad_points_id);

        $title = $request->title;
        $time_claimed = $request->time_claimed;
        $watch_ads_value = $request->watch_ads_value;
        $point_number = $request->point_number;
        $point_value = $request->point_value;

        $findRewardsAdPoints->title = $title;
        $findRewardsAdPoints->time_claimed = $time_claimed;
        $findRewardsAdPoints->watch_ads_value = $watch_ads_value;
        $findRewardsAdPoints->point_number = $point_number;
        $findRewardsAdPoints->point_value = $point_value;

        $findRewardsAdPoints->save();
        if ($findRewardsAdPoints) {
            return response()->json(['message' => 'RewardsAdPoints berhasil diubah'], 200);
        } else {
           return response()->json(['message' => 'RewardsAdPoints gagal diubah'], 500);
       }

    }

    public function detailRewardsAdPoints($id) {
        $mRewardsAdPoints = RewardsAdPoints::findOrFail($id);
        return view('layouts/page/edit/edit-rewards-ad-points', compact('mRewardsAdPoints'));
    }

    public function deleteRewardsAdPoints($id) {
        $mRewardsAdPoints = RewardsAdPoints::findOrFail($id);
        $mRewardsAdPoints->delete();
        if ($mRewardsAdPoints) {
           return redirect('/rewards-ad-points');
        } else {
           return response()->json(['message' => 'RewardsAdPoints gagal dihapus'], 500);
       }
    }
}
