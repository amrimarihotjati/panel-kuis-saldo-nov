<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class AvatarController extends Controller
{
    public function getDTAvatar(Request $request)
    {
        $query = Avatar::query()->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountAvatar(Request $request)
    {
        $data = Avatar::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createAvatar(Request $request)
    {
        $avatarName = $request->avatar_name;

        if ($request->file('avatar_icon')) {
            $newImage = $request->file('avatar_icon');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/player_avatar'), $filename);

            $mAvatar = Avatar::create([
                'avatar_name' => $avatarName,
                'avatar_icon' => env('APP_URL') . '/uploads/player_avatar/' . $filename,
            ]);

            if ($mAvatar) {
                return response()->json(['message' => 'Avatar berhasil dibuat'], 200);
            } else {
                 return response()->json(['message' => 'Avatar gagal dibuat'], 500);
            }
        }
    }

    public function editAvatar(Request $request) {
        $findAvatar = Avatar::findOrFail($request->avatar_id);
        $avatarName = $request->avatar_name;
        if ($request->file('avatar_icon')) {
            $newImage = $request->file('avatar_icon');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/player_avatar'), $filename);

            $findAvatar->avatar_name = $avatarName;
            $findAvatar->avatar_icon = env('APP_URL') . '/uploads/player_avatar/' . $filename;
            $findAvatar->save();

            if ($findAvatar) {
                return response()->json(['message' => 'Avatar berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Avatar gagal diubah'], 500);
            }
        } else {
            $findAvatar->avatar_name = $avatarName;
            $findAvatar->save();
            if ($findAvatar) {
                return response()->json(['message' => 'Avatar berhasil diubah'], 200);
            } else {
                 return response()->json(['message' => 'Avatar gagal diubah'], 500);
            }
        }
    }

    public function detailAvatar($id) {
        $mAvatar = Avatar::findOrFail($id);
        return view('layouts/page/edit/edit-avatar', compact('mAvatar'));
    }

    public function deleteAvatar($id) {
        $mAvatar = Avatar::findOrFail($id);
        $mAvatar->delete();
        if ($mAvatar) {
           return redirect('/avatar');
        } else {
           return response()->json(['message' => 'Avatar gagal dihapus'], 500);
       }
    }

}
