<?php 

namespace App\Services\Stripe;

use App\DTOs\Stripe\UpdatePackageDTO as UpdateStripePackageDTO;
use App\Exceptions\CustomException;
use App\Jobs\UpdateStripeProductJob;
use Symfony\Component\HttpFoundation\Response;

class StripeManagerService 
{
    public function __construct(
        protected StripeProductServiceInterface $productService, 
        protected StripePriceServiceInterface $priceService
    ) { }

    public function createProductWithPrice(string $name, string $description, float $amount, int $intervalCount = 1, bool $active = true): array
    {
        // Create Product
        $product = $this->productService->createProduct($name, $description, $active);

        try {
            // Create Price for the Product
            $price = $this->priceService->createPrice($product->id, $amount, $intervalCount, $active);

            return [
                'product' => $product,
                'price' => $price,
            ];
        } catch (CustomException $e) {
            // delete created product when price does not created
            $this->productService->deleteProduct($product->id);

            throw new CustomException("Failed to create price. Product has been deleted.", Response::HTTP_BAD_REQUEST, [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);
        } 

    }

    public function updateProductWithPrice(UpdateStripePackageDTO $updateStripePackageDTO): void
    {
        UpdateStripeProductJob::dispatch($updateStripePackageDTO);
    }

    public function deactivateProductAndPrice(string $productId, string $priceId): void
    {
        $product = $this->productService->updateProduct($productId, active: false);
        $price = $this->priceService->changeActivePrice($priceId, false);

        if (!$product->updated || $product->active !== false || $price->active !== false) {
            throw new CustomException('Product and price does not deactivated');
        }
    }
}