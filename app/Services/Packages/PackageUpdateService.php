<?php 
namespace App\Services\Packages;

use App\DTOs\Stripe\UpdatePackageDTO as UpdateStripePackageDTO;
use App\Models\Package;
use App\Services\Stripe\StripeManagerService;
use Illuminate\Support\Facades\DB;

class PackageUpdateService
{
    public function __construct(
        protected PackageService $packageService, 
        protected StripeManagerService $stripeManagerService
    ) { }

    public function updatePackageWithStripe(Package $package, array $data, ?array $specialties): Package
    {
        DB::transaction(function () use ($package, $data, $specialties) {
            $updatedPackage = $this->packageService->updatePackage($package, $data, $specialties); 
            $stripePackageDTO = new UpdateStripePackageDTO($updatedPackage);
            $this->stripeManagerService->updateProductWithPrice($stripePackageDTO);
        });
        
        return $package;
    }
}
