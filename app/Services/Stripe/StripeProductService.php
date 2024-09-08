<?php

namespace App\Services\Stripe;

use App\Exceptions\CustomException;
use App\Helpers\DataHelper;
use Exception;
use Stripe\Product as StripeProduct;
use Stripe\Stripe;
use Stripe\StripeClientInterface;
use Symfony\Component\HttpFoundation\Response;

class StripeProductService implements StripeProductServiceInterface
{
    public function __construct()
    {
        // Set Stripe API key
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createProduct(string $name, string $description, bool $active = true): StripeProduct
    {
        try {
            return StripeProduct::create([
                'name' => $name,
                'description' => $description,
                'active' => $active,
            ]);
        } catch (Exception $e) {
            throw new CustomException("Failed to create product: $name", Response::HTTP_INTERNAL_SERVER_ERROR, [
                'name' => $name,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function deleteProduct(string $productId): void
    {
        try {
            // Retrieve the product
            $product = StripeProduct::retrieve($productId);

            // Delete the product
            $product->delete();
        } catch (Exception $e) {
            throw new CustomException("Failed to delete product: $productId", Response::HTTP_INTERNAL_SERVER_ERROR, [
                'product_id' => $productId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function updateProduct(string $productId, ?string $name = null, ?string $description = null, ?bool $active = null): ?StripeProduct
    {
        $data = $this->prepareProductData($name, $description, $active);
        
        if (empty($data)) {
            return null; 
        }

        return $this->performProductUpdate($productId, $data);
    }

    private function prepareProductData(?string $name, ?string $description, ?bool $active): array
    {
        return DataHelper::filterNullValues([
            'name' => $name,
            'description' => $description,
            'active' => $active,
        ]);
    }

    private function performProductUpdate(string $productId, array $data): StripeProduct
    {
        try {
            return StripeProduct::update($productId, $data);
        } catch (Exception $e) {
            throw new CustomException("Failed to update product: $productId", Response::HTTP_INTERNAL_SERVER_ERROR, [
                'product_id' => $productId,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
