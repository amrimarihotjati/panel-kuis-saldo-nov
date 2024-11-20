<?php

namespace App\Http\Controllers;

use App\Models\AdsCounterTemporary;
use App\Models\Player;

use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class AdsCounterTemporaryController extends Controller
{
    public function getDTAdsCounterTemporary(Request $request)
    {
        $player_id = $request->player_id;

        $query = AdsCounterTemporary::query()
        ->with('player')
        ->where('player_id', $player_id);

        return Datatables::eloquent($query)->toJson();
    }

    public function getDataStatisticWatchedAds($player_id)
    {
        $mPlayer = Player::where('id', $player_id)->first();

        $mAdsCounterTemporaryInterstitial = AdsCounterTemporary::where('player_id', $mPlayer->id)
        ->get()
        ->sum('ads_watched_inters');

        $mAdsCounterTemporaryRewards = AdsCounterTemporary::where('player_id', $mPlayer->id)
        ->get()
        ->sum('ads_watched_rewards');

        $mAdsCounterTemporaryTotal = $mAdsCounterTemporaryInterstitial + $mAdsCounterTemporaryRewards;

        $data = [
            'player' => $mPlayer,
            'ads_watched_inters' => $mAdsCounterTemporaryInterstitial,
            'ads_watched_rewards' => $mAdsCounterTemporaryRewards,
            'ads_watched_totals' => $mAdsCounterTemporaryTotal,
        ];

        return response()->json($data);
    }

    public function resetAllDataTemporaryAds(Request $request)
    {
        $player_id = $request->player_id;
        $dataAdsTemporary = AdsCounterTemporary::where('player_id', $player_id)->get();
        if ($dataAdsTemporary->isEmpty()) {
            return response()->json(['message' => 'Data ads kosong'], 500);
        }
        foreach ($dataAdsTemporary as $adsTemporary) {
            $adsTemporary->delete();
        }
        return response()->json(['message' => 'Ads temporary data berhasil dihapus'], 200);
    }

}
