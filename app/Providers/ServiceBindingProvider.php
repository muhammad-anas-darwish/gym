<?php

namespace App\Providers;

use App\Services\Coupons\CouponProcessor;
use App\Services\Coupons\CouponProcessorInterface;
use App\Services\Coupons\CouponService;
use App\Services\Coupons\CouponServiceInterface;
use App\Services\Packages\PackageService;
use App\Services\Packages\PackageServiceInterface;
use App\Services\Stripe\Coupons\StripeCouponFacade;
use App\Services\Stripe\Coupons\StripeCouponFacadeInterface;
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
        
        $this->app->bind(CouponProcessorInterface::class, CouponProcessor::class);
        $this->app->bind(CouponServiceInterface::class, CouponService::class);
        $this->app->bind(StripeCouponFacadeInterface::class, StripeCouponFacade::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
