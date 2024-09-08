<?php

namespace App\Services\Packages;

use App\Models\Package;

interface PackageServiceInterface
{
    public function createPackage(array $data, ?array $specialties = null): Package;

    public function attachPackageWithStripe(Package $package, string $stripeProductId, string $stripePriceId): Package;

    public function updatePackageWithNewPrice(Package $package, string $newPriceId): void;

    public function updatePackage(Package $package, array $data, ?array $specialties): Package;
}