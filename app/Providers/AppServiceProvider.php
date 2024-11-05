<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Auth\AuthInterface;
use App\Repositories\Auth\AuthRepository;

use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository;

use App\Repositories\Service\ServiceInterface;
use App\Repositories\Service\ServiceRepository;

use App\Repositories\Package\PackageInterface;
use App\Repositories\Package\PackageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);

        $this->app->bind(CategoryInterface::class, CategoryRepository::class);

        $this->app->bind(ServiceInterface::class, ServiceRepository::class);
        
        $this->app->bind(PackageInterface::class, PackageRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
