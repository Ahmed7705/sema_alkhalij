<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        if ($request->hasFile('logo') || $request->hasFile('site_logo')) {
            $file = $request->file('logo') ?? $request->file('site_logo');
            $ext = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'logo_' . time() . '.' . $ext;
            
            // Save inside public/images/
            $file->move(public_path('images'), $filename);
            
            $relativeLogoPath = 'images/' . $filename;
            
            // Update in DB & flush cache
            SettingsService::set('site_logo', $relativeLogoPath);
            
            // Overwrite logo.png for static legacy image fallback
            try {
                @copy(public_path($relativeLogoPath), public_path('images/logo.png'));
            } catch (\Exception $e) {
                // Ignore copy error if locked
            }
        }

        $inputs = $request->except(['_token', 'logo', 'site_logo']);

        foreach ($inputs as $key => $value) {
            $val = $value ?? '';
            SettingsService::set($key, $val);
            
            // Sync key aliases for backward compatibility
            if ($key === 'site_title') SettingsService::set('company_name', $val);
            if ($key === 'site_phone') SettingsService::set('contact_phone', $val);
            if ($key === 'site_email') SettingsService::set('contact_email', $val);
            if ($key === 'whatsapp_number') SettingsService::set('whatsapp_phone', $val);
            if ($key === 'vat_percentage') SettingsService::set('vat_rate', $val);
        }

        // Flush all application cache immediately
        Cache::flush();

        return back()->with('success', 'تم حفظ وتحديث إعدادات الموقع والشعار والنظام فوراً.');
    }
}
