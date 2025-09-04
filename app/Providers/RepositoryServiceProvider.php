<?php

namespace App\Providers;

use App\Contracts\Repositories\ActivityRepositoryInterface;
use App\Contracts\Repositories\BuildingRepositoryInterface;
use App\Contracts\Repositories\OrganizationRepositoryInterface;
use App\Repositories\ActivityRepository;
use App\Repositories\BuildingRepository;
use App\Repositories\OrganizationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Репозитории
        $this->app->bind(BuildingRepositoryInterface::class, BuildingRepository::class);
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(OrganizationRepositoryInterface::class, OrganizationRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
