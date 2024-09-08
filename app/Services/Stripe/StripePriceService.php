<?php

namespace App\Services\Stripe;

use App\Exceptions\CustomException;
use Exception;
use Stripe\Price as StripePrice;
use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;

class StripePriceService implements StripePriceServiceInterface
{
    public function __construct()
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createPrice(string $productId, float $amount, int $interval_count = 1, bool $active = true): StripePrice
    {
        try {
            return StripePrice::create([
                'currency' => config('services.stripe.currency'),
                'unit_amount' => $amount * 100,
                'recurring' => [
                    'interval' => 'month',
                    'interval_count' => $interval_count,
                ],
                'active' => $active,
                'product' => $productId,
            ]);
        } catch (Exception $e) {
            throw new CustomException("Failed to create price for product: $productId", Response::HTTP_INTERNAL_SERVER_ERROR, [
                'product_id' => $productId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function retrievePrice(string $priceId): StripePrice
    {
        return StripePrice::retrieve($priceId);
    }

    public function updatePrice(string $priceId, float $amount, int $interval_count, bool $active): StripePrice
    {
        $currentPrice = $this->retrievePrice($priceId);
        $productId = $currentPrice->product; 

        if ($this->hasPriceChanged($currentPrice, $amount, $interval_count)) {
            $this->archiveOldPrice($priceId);
            return $this->createPrice($productId, $amount, $interval_count, $active);
        }

        return $this->performPriceUpdate($priceId, ['active' => $active]);
    }

    public function hasPriceChanged(StripePrice $currentPrice, float $amount, int $interval_count): bool
    {
        $currentAmount = $currentPrice->unit_amount / 100; 
        $currentIntervalCount = $currentPrice->recurring->interval_count;

        return $currentAmount !== $amount || $currentIntervalCount !== $interval_count;
    }

    public function archiveOldPrice(string $priceId): void
    {
        $this->performPriceUpdate($priceId, ['active' => false]);
    }

    private function performPriceUpdate(string $priceId, array $data): StripePrice
    {
        try {
            return StripePrice::update($priceId, $data);
        } catch (Exception $e) {
            throw new CustomException("Failed to update price: $priceId", Response::HTTP_INTERNAL_SERVER_ERROR, [
                'price_id' => $priceId,
                'error' => $e->getMessage(),
            ]);
        }
    }
}