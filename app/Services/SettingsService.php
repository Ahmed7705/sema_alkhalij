<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Default Cache Time-To-Live in seconds (24 hours).
     */
    protected static int $ttl = 86400;

    /**
     * Get a setting by key with TTL caching.
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = "site_setting_{$key}";

        return Cache::remember($cacheKey, static::$ttl, function () use ($key, $default) {
            $setting = SiteSetting::where('key', $key)->first();
            return $setting && !is_null($setting->value) ? $setting->value : $default;
        });
    }

    /**
     * Set a setting key-value pair and AUTOMATICALLY clear its cache immediately.
     */
    public static function set(string $key, $value, string $group = 'general'): SiteSetting
    {
        $setting = SiteSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group]
        );

        // Instantly invalidate cache so UI updates immediately
        static::forgetCache($key);

        return $setting;
    }

    /**
     * Clear the cache for a specific key.
     */
    public static function forgetCache(string $key): void
    {
        Cache::forget("site_setting_{$key}");
    }

    /**
     * Get dynamic VAT percentage rate (default 15).
     */
    public static function getVatRate(): float
    {
        return (float) static::get('vat_rate', 15.0);
    }
}
