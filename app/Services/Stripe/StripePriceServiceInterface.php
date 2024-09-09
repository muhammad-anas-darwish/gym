<?php

namespace App\Services\Stripe;

use Stripe\Price as StripePrice;

interface StripePriceServiceInterface
{
    public function createPrice(string $productId, float $amount, int $interval_count = 1, bool $active = true): StripePrice;
    
    public function updatePrice(string $priceId, float $amount, int $interval_count, bool $active): StripePrice;

    public function changeActivePrice(string $priceId, bool $active): StripePrice;
}