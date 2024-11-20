<?php

namespace App\Http\Controllers;

use App\Models\PanelSetting;
use Illuminate\Http\Request;

class PanelSettingController extends Controller
{
    public function getSettingList() {
        $mPanelSettingList = PanelSetting::all();
        return view('layouts/page/jobservices/panel-setting', compact('mPanelSettingList'));
    }

    public function updateSettingList(Request $request)
    {
        $settings = $request->input('settings', []);
        $allSettings = PanelSetting::all();

        foreach ($allSettings as $setting) {
            $status = isset($settings[$setting->id]) ? 1 : 0;
            $setting->update(['status' => $status]);
        }

        return response()->json(['message' => 'Pengaturan berhasil disimpan'], 200);
    }

}
