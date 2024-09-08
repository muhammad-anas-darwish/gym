<?php

namespace App\Services\Stripe;

use Stripe\Product as StripeProduct;

interface StripeProductServiceInterface
{
   

    public function createProduct(string $name, string $description, bool $active = true): StripeProduct;

    public function deleteProduct(string $productId): void;

    public function updateProduct(string $productId, ?string $name = null, ?string $description = null, ?bool $active = null): ?StripeProduct;
}
