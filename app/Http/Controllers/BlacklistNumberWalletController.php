<?php

namespace App\Http\Controllers;

use App\Models\BlacklistNumberWallet;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables;

class BlacklistNumberWalletController extends Controller
{
    public function getDTBlacklistNumber(Request $request)
    {
        $query = BlacklistNumberWallet::query()->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function createBlacklistNumber(Request $request)
    {
        $number_wallet = $request->number_wallet;

        if (BlacklistNumberWallet::where('number_wallet', $number_wallet)->exists()) {
            return response()->json(['message' => 'Nomor wallet sudah ada di dalam daftar blacklist'], 500);
        }

        $mBlacklistNumberWallet = BlacklistNumberWallet::create([
            'number_wallet' => $number_wallet,
        ]);

        if ($mBlacklistNumberWallet) {
            return response()->json(['message' => 'Nomor wallet berhasil dimasukan blacklist'], 200);
        } else {
            return response()->json(['message' => 'Nomor wallet gagal dimasukan blacklist'], 500);
        }
    }

    public function removeBlacklistNumber($id) {
        $mBlacklistNumberWallet = BlacklistNumberWallet::findOrFail($id);
        $mBlacklistNumberWallet->delete();
        if ($mBlacklistNumberWallet) {
           return redirect('/blacklist-number-wallet');
        } else {
           return response()->json(['message' => 'Nomor wallet gagal dihapus'], 500);
       }
    }

}
