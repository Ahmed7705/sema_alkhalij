<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingsManagerController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle logo upload if provided
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $file->move(public_path('images'), 'logo.png');
            SiteSetting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => 'images/logo.png']
            );
        }

        $inputs = $request->except(['_token', 'logo']);

        foreach ($inputs as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        return back()->with('success', 'تم حفظ وتحديث إعدادات الموقع والنظام فوراً.');
    }
}
