<?php

namespace App\Providers;

use App\Models\Department;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\DevelopmentRepositoryInterface;
use App\Repositories\Eloquent\DevelopmentRepository;

use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Eloquent\ProjectRepository;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Eloquent\DepartmentRepository;

use App\Repositories\Interfaces\MarketingRepositoryInterface;
use App\Repositories\Eloquent\MarketingRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DevelopmentRepositoryInterface::class, DevelopmentRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(MarketingRepositoryInterface::class, MarketingRepository::class);



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
