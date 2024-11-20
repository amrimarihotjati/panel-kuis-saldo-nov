<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class BannerController extends Controller
{
     public function getDTBanner(Request $request)
    {
        $query = Banner::query()->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountBanner(Request $request)
    {
        $data = Banner::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createBanner(Request $request)
    {
        $bannerTitle = $request->banner_title;
        $bannerUrl = $request->banner_url;
        $bannerDescription = $request->banner_description;

        if ($request->file('banner_image')) {
            $newImage = $request->file('banner_image');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/banner_app'), $filename);

            $mBanner = Banner::create([
                'banner_title' => $bannerTitle,
                'banner_url' => $bannerUrl,
                'banner_description' => $bannerDescription,
                'banner_image' => env('APP_URL') . '/uploads/banner_app/' . $filename,
            ]);

            if ($mBanner) {
                return response()->json(['message' => 'Banner berhasil dibuat'], 200);
            } else {
                 return response()->json(['message' => 'Banner gagal dibuat'], 500);
            }
        }
    }

    public function editBanner(Request $request) {
        $findBanner = Banner::findOrFail($request->banner_id);
        $bannerTitle = $request->banner_title;
        $bannerUrl = $request->banner_url;
        $bannerDescription = $request->banner_description;

        if ($request->file('banner_image')) {
            $newImage = $request->file('banner_image');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/banner_app'), $filename);

            $findBanner->banner_title = $bannerTitle;
            $findBanner->banner_url = $bannerUrl;
            $findBanner->banner_description = $bannerDescription;
            $findBanner->banner_image = env('APP_URL') . '/uploads/banner_app/' . $filename;
            $findBanner->save();

            if ($findBanner) {
                return response()->json(['message' => 'Banner berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Banner gagal diubah'], 500);
            }
        } else {
            $findBanner->banner_title = $bannerTitle;
            $findBanner->banner_url = $bannerUrl;
            $findBanner->banner_description = $bannerDescription;
            $findBanner->save();
            if ($findBanner) {
                return response()->json(['message' => 'Banner berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Banner gagal diubah'], 500);
            }
        }
    }

    public function detailBanner($id) {
        $mBanner = Banner::findOrFail($id);
        return view('layouts/page/edit/edit-banner', compact('mBanner'));
    }

    public function deleteBanner($id) {
        $mBanner = Banner::findOrFail($id);
        $mBanner->delete();
        if ($mBanner) {
           return redirect('/banner');
        } else {
           return response()->json(['message' => 'Banner gagal dihapus'], 500);
       }
    }
}
