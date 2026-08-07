<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Service;
use App\Models\Product;
use App\Policies\BookingPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ServicePolicy;
use App\Policies\ProductPolicy;
use App\Policies\SettingPolicy;

use App\Models\Company;
use App\Policies\CompanyPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Order::class => OrderPolicy::class,
        Service::class => ServicePolicy::class,
        Product::class => ProductPolicy::class,
        Company::class => CompanyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate for Admin Control Panel Access
        Gate::define('access-admin', function ($user) {
            return $user->isAdmin();
        });

        // Gate for Managing Settings
        Gate::define('manage-settings', function ($user) {
            return $user->isAdmin();
        });
    }
}
