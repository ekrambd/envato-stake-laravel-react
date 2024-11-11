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

use App\Repositories\Purchase\PurchaseInterface;
use App\Repositories\Purchase\PurchaseRepository;

use App\Repositories\Withdraw\WithdrawInterface;
use App\Repositories\Withdraw\WithdrawRepository;


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
        
        $this->app->bind(PurchaseInterface::class, PurchaseRepository::class);

        $this->app->bind(WithdrawInterface::class, WithdrawRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
