<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RegistrationSetting;
use Illuminate\Http\Request;

class AdminRegistrationSettingController extends Controller
{
    public function edit()
    {
        $setting = RegistrationSetting::first();

        if (! $setting) {
            $setting = RegistrationSetting::create([
                'registration_fee' => 0,
            ]);
        }

        return view('admin.registration-settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'registration_fee' => 'required|integer|min:0',
        ]);

        $setting = RegistrationSetting::first();

        if (! $setting) {
            $setting = RegistrationSetting::create([
                'registration_fee' => $request->registration_fee,
            ]);
        } else {
            $setting->update([
                'registration_fee' => $request->registration_fee,
            ]);
        }

        return back()->with('success', 'Registration fee updated successfully.');
    }
}
