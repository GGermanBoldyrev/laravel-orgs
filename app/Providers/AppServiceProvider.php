<?php

namespace App\Providers;

use App\Services\ActivityService;
use App\Services\LocationService;
use App\Services\OrganizationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Сервисы
        $this->app->singleton(LocationService::class);
        $this->app->singleton(ActivityService::class);
        $this->app->singleton(OrganizationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
