<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;

class PaymentMethodController extends Controller
{
    public function getDTPaymentMethod(Request $request)
    {
        $query = PaymentMethod::query()->orderBy('created_at', 'desc');
        return Datatables::eloquent($query)->toJson();
    }

    public function getCountPaymentMethod(Request $request)
    {
        $data = PaymentMethod::select('*')
        ->orderBy('created_at', 'desc')
        ->get();
        return $data->count();
    }

    public function createPaymentMethod(Request $request) {
        $methodName = $request->method;

        if ($request->file('method_image')) {
            $newImage = $request->file('method_image');
            $filerandom = Str::random(30, 'alpha_num_or_symbols');
            $filename = $filerandom . '.png';
            $newImage->move(public_path('uploads/payment_method'), $filename);

            $mPaymentMethod = PaymentMethod::create([
                'method' => $methodName,
                'method_image' => env('APP_URL') . '/uploads/payment_method/' . $filename,
            ]);

            if ($mPaymentMethod) {
                return response()->json(['message' => 'Payment Method berhasil dibuat'], 200);
            } else {
                 return response()->json(['message' => 'Payment Method gagal dibuat'], 500);
            }
        }
    }

    public function deletePaymentMethod($id) {
        $mPaymentMethod = PaymentMethod::findOrFail($id);
        $mPaymentMethod->delete();
        if ($mPaymentMethod) {
           return redirect('/payment-method');
        } else {
           return response()->json(['message' => 'Payment Method gagal dihapus'], 500);
       }
    }

}
