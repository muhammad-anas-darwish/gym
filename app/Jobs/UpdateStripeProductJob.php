<?php

namespace App\Jobs;

use App\DTOs\Stripe\UpdatePackageDTO;
use App\Services\Packages\PackageServiceInterface;
use App\Services\Stripe\StripePriceServiceInterface;
use App\Services\Stripe\StripeProductServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateStripeProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $backoff = 10;

    /**
     * Create a new job instance.
     */
    public function __construct(protected UpdatePackageDTO $updateDTO) 
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(StripeProductServiceInterface $stripeProductService, StripePriceServiceInterface $stripePriceService, PackageServiceInterface $packageService): void
    {
        $stripeProductService->updateProduct(
            $this->updateDTO->getProductId(),
            $this->updateDTO->getName(),
            $this->updateDTO->getDescription(),
            $this->updateDTO->getActive()
        );

        $stripePrice = $stripePriceService->updatePrice(
            $this->updateDTO->getPriceId(),
            $this->updateDTO->getAmount(),
            $this->updateDTO->getIntervalCount(),
            $this->updateDTO->getActive()
        );

        $packageService->updatePackageWithNewPrice($this->updateDTO->getPackage(), $stripePrice->id);    
    }
}
