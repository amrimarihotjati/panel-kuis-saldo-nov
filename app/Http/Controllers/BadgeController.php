<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class BadgeController extends Controller
{
   public function getDTBadge(Request $request)
    {
        $query = Badge::query()->orderBy('created_at', 'desc')->orderBy('badge_level', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountBadge(Request $request)
    {
        $data = Badge::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createBadge(Request $request)
    {
        $badgeName = $request->badge_name;
        $badgePrice = $request->badge_price;
        $badgeLevel = $request->badge_level;

        if ($request->file('badge_icon')) {
            $newImage = $request->file('badge_icon');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/player_badge'), $filename);

            $mBadge = Badge::create([
                'badge_name' => $badgeName,
                'badge_price' => $badgePrice,
                'badge_level' => $badgeLevel,
                'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/' . $filename,
            ]);

            if ($mBadge) {
                return response()->json(['message' => 'Badge berhasil dibuat'], 200);
            } else {
                 return response()->json(['message' => 'Badge gagal dibuat'], 500);
            }
        }
    }

    public function editBadge(Request $request) {
        $findBadge = Badge::findOrFail($request->badge_id);

        $badgeName = $request->badge_name;
        $badgePrice = $request->badge_price;
        $badgeLevel = $request->badge_level;

        if ($request->file('badge_icon')) {
            $newImage = $request->file('badge_icon');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/player_badge'), $filename);

            $findBadge->badge_name = $badgeName;
            $findBadge->badge_price = $badgePrice;
            $findBadge->badge_level = $badgeLevel;
            $findBadge->badge_icon = 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/' . $filename;
            $findBadge->save();

            if ($findBadge) {
                return response()->json(['message' => 'Badge berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Badge gagal diubah'], 500);
            }
        } else {
            $findBadge->badge_name = $badgeName;
            $findBadge->badge_price = $badgePrice;
            $findBadge->badge_level = $badgeLevel;
            $findBadge->save();
            if ($findBadge) {
                return response()->json(['message' => 'Badge berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Badge gagal diubah'], 500);
            }
        }
    }

    public function detailBadge($id) {
        $mBadge = Badge::findOrFail($id);
        return view('layouts/page/edit/edit-badge', compact('mBadge'));
    }

    public function deleteBadge($id) {
        $mBadge = Badge::findOrFail($id);
        $mBadge->delete();
        if ($mBadge) {
           return redirect('/badge');
        } else {
           return response()->json(['message' => 'Badge gagal dihapus'], 500);
       }
    }

}
