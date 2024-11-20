<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Player;
use App\Models\BaseApplication;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Hash;

use App\Helper\ApiFormatter;

class PlayerResetPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        $head_app_id = $request->header('app_id');
        $head_app_pkg = $request->header('app_pkg');
        $head_app_code = $request->header('app_code');
        $head_app_access_key = $request->header('app_access_key');

        $head_device_id = 'TEST';
        $head_device_name = 'TEST';

        if (is_null($head_app_pkg) || is_null($head_app_id) || is_null($head_app_code) || is_null($head_app_access_key)) {
            return ApiFormatter::createApiFailed('ACCESS DENIED');
        }

        $mBaseApplication = BaseApplication::where('id', $head_app_id)->where('app_pkg', $head_app_pkg)->where('app_access_key', $head_app_access_key)->first();

        if (is_null($mBaseApplication)) {
            return ApiFormatter::createApiFailed('ACCESS MAIN APPLICATION DENIED');
        }

        if ($mBaseApplication->settings_validation_device_api == 1) {
            $head_device_id = $request->header('device_id');
            $head_device_name = $request->header('device_name');
        }

        $playerMail = $request->email;

        if (is_null($playerMail)) {
            return ApiFormatter::createApiFailed('DATA REQUIRED!');
        }

        $player = Player::where('email', $playerMail)->where('player_pkg', $head_app_pkg)->first();
        if (is_null($player)) {
            return ApiFormatter::createApiFailed('Email player tidak ditemukan');
        }

        $token = Str::random(60);

        $player->reset_token_password = $token;
        $player->save();

        $resetLink = url("/reset-password/{$token}");

        try {
            Mail::send('layouts.verification.account.reset-password', ['resetLink' => $resetLink], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });
            return ApiFormatter::createApiSuccess('Tautan reset password berhasil dikirim ke alamat email terdaftar', ['Player' => $player]);
        } catch (\Exception $e) {
            return ApiFormatter::createApiFailed('Terjadi kesalahan server, silahkan coba lagi.');
        }
    }

    public function showResetForm($token)
    {
        return view('layouts.verification.account.form-reset-pass', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $player = Player::where('reset_token_password', $request->token)->firstOrFail();

        $player->password = bcrypt($request->password);
        $player->reset_token_password = null;
        $player->save();

        return view('layouts.verification.account.success-reset-password')->with('status', 'Password has been reset.');
    }
}
