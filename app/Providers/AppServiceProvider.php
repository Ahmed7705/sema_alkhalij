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
                        'company_name' => SettingsService::get('site_title', SettingsService::get('company_name', 'سيما الخليج للخدمات الطبية')),
                        'site_title' => SettingsService::get('site_title', SettingsService::get('company_name', 'سيما الخليج للخدمات الطبية')),
                        'contact_phone' => SettingsService::get('site_phone', SettingsService::get('contact_phone', '0545880082')),
                        'site_phone' => SettingsService::get('site_phone', SettingsService::get('contact_phone', '0545880082')),
                        'contact_email' => SettingsService::get('site_email', SettingsService::get('contact_email', 'info@sema-alkhalij.sa')),
                        'site_email' => SettingsService::get('site_email', SettingsService::get('contact_email', 'info@sema-alkhalij.sa')),
                        'whatsapp_phone' => SettingsService::get('whatsapp_number', SettingsService::get('whatsapp_phone', '966545880082')),
                        'whatsapp_number' => SettingsService::get('whatsapp_number', SettingsService::get('whatsapp_phone', '966545880082')),
                        'site_logo' => SettingsService::get('site_logo', 'images/logo.png'),
                        'address' => SettingsService::get('address', 'طريق المدينة المنورة، حي الرويس، جدة، المملكة العربية السعودية'),
                        'vat_rate' => SettingsService::get('vat_percentage', SettingsService::getVatRate()),
                        'vat_number' => SettingsService::get('vat_number', '300000000000003'),
                        'seo_meta_title' => SettingsService::get('seo_title', SettingsService::get('seo_meta_title', 'سيما الخليج | رعاية صحية منزلية متخصصة ومستلزمات طبية')),
                        'seo_meta_description' => SettingsService::get('seo_description', SettingsService::get('seo_meta_description', 'سيما الخليج للخدمات الطبية توفر أفضل خدمات الرعاية الصحية المنزلية والمستلزمات الطبية المعتمدة في المملكة.')),
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
