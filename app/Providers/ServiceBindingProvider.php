<?php

namespace App\Providers;

use App\Services\Packages\PackageService;
use App\Services\Packages\PackageServiceInterface;
use App\Services\Stripe\StripePriceService;
use App\Services\Stripe\StripePriceServiceInterface;
use App\Services\Stripe\StripeProductService;
use App\Services\Stripe\StripeProductServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceBindingProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StripeProductServiceInterface::class, StripeProductService::class);
        $this->app->bind(StripePriceServiceInterface::class, StripePriceService::class);

        $this->app->bind(PackageServiceInterface::class, PackageService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
