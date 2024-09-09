<?php

namespace App\Services\Packages;

use App\Exceptions\CustomException;
use App\Models\Package;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PackageService implements PackageServiceInterface
{
    public function createPackage(array $data, ?array $specialties = null): Package
    {
        $package = Package::create($data);

        if (!is_null($specialties)) {
            $package->specialties()->attach($specialties);
        }
        
        return $package;
    }

    public function attachPackageWithStripe(Package $package, string $stripeProductId, string $stripePriceId): Package
    {
        $package->update([
            'stripe_product_id' => $stripeProductId,
            'stripe_price_id' => $stripePriceId,
        ]);

        return $package;
    }

    public function updatePackageWithNewPrice(Package $package, string $newPriceId): void
    {
        DB::beginTransaction();
        try {
            $package->update(['stripe_price_id' => $newPriceId]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new CustomException('Package Price Does not updated.', Response::HTTP_INTERNAL_SERVER_ERROR, [
                'packageId' => $package->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function updatePackage(Package $package, array $data, ?array $specialties): Package
    {
        $package->update($data);

        if (!is_null($specialties)) {
            $package->specialties()->attach($specialties);
        }

        return $package;
    }

    public function deletePackage(Package $package): void
    {
        $package->delete();
    }
}