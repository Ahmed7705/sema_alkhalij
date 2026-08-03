<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::component('layouts.admin', 'admin-layout');

        // Share global site settings with all Blade views safely
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('site_settings')) {
                    $settings = [
                        'company_name' => SettingsService::get('company_name', 'سيما الخليج للخدمات الطبية'),
                        'contact_phone' => SettingsService::get('contact_phone', '920000000'),
                        'contact_email' => SettingsService::get('contact_email', 'info@sema-alkhalij.com'),
                        'whatsapp_phone' => SettingsService::get('whatsapp_phone', '966500000000'),
                        'address' => SettingsService::get('address', 'الرياض، المملكة العربية السعودية'),
                        'vat_rate' => SettingsService::getVatRate(),
                        'vat_number' => SettingsService::get('vat_number', '300000000000003'),
                        'seo_meta_title' => SettingsService::get('seo_meta_title', 'سيما الخليج | رعاية صحية منزلية متخصصة ومستلزمات طبية'),
                        'seo_meta_description' => SettingsService::get('seo_meta_description', 'سيما الخليج للخدمات الطبية توفر أفضل خدمات الرعاية الصحية المنزلية والمستلزمات الطبية المعتمدة في المملكة.'),
                        'working_hours' => SettingsService::get('working_hours', '24/7 طوال أيام الأسبوع'),
                    ];
                    $view->with('siteSettings', $settings);
                }
            } catch (\Exception $e) {
                \Log::warning('Global settings view composer warning: ' . $e->getMessage());
            }
        });
    }
}
