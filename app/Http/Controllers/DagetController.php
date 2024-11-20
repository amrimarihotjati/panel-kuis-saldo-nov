<?php

namespace App\Http\Controllers;

use App\Models\Daget;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class DagetController extends Controller
{
    public function getDTDaget(Request $request)
    {
        $query = Daget::query()->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountDaget(Request $request)
    {
        $data = Daget::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createDaget(Request $request)
    {
        $title = $request->title;
        $url = $request->url;
        $time_claimed = $request->time_claimed;
        $watch_ads_value = $request->watch_ads_value;
        $info_rupiah = $request->info_rupiah;

        $mDaget = Daget::create([
            'title' => $title,
            'url' => $url,
            'time_claimed' => $time_claimed,
            'watch_ads_value' => $watch_ads_value,
            'info_rupiah' => $info_rupiah
        ]);

        if ($mDaget) {
            return response()->json(['message' => 'Daget berhasil dibuat'], 200);
        } else {
           return response()->json(['message' => 'Daget gagal dibuat'], 500);
       }
    }

    public function editDaget(Request $request) {
        $findDaget = Daget::findOrFail($request->daget_id);

        $title = $request->title;
        $url = $request->url;
        $time_claimed = $request->time_claimed;
        $watch_ads_value = $request->watch_ads_value;
        $info_rupiah = $request->info_rupiah;
        $daget_number = $request->daget_number;

        $findDaget->title = $title;
        $findDaget->url = $url;
        $findDaget->time_claimed = $time_claimed;
        $findDaget->watch_ads_value = $watch_ads_value;
        $findDaget->info_rupiah = $info_rupiah;
        $findDaget->daget_number = $daget_number;

        $findDaget->save();
        if ($findDaget) {
            return response()->json(['message' => 'Daget berhasil diubah'], 200);
        } else {
           return response()->json(['message' => 'Daget gagal diubah'], 500);
       }

    }

    public function detailDaget($id) {
        $mDaget = Daget::findOrFail($id);
        return view('layouts/page/edit/edit-daget', compact('mDaget'));
    }

    public function deleteDaget($id) {
        $mDaget = Daget::findOrFail($id);
        $mDaget->delete();
        if ($mDaget) {
           return redirect('/dana-kaget');
        } else {
           return response()->json(['message' => 'Daget gagal dihapus'], 500);
       }
    }

}
