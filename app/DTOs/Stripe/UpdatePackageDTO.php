<?php 

namespace App\DTOs\Stripe;
use App\Models\Package;

class UpdatePackageDTO
{
    public string $productId;
    public string $priceId;
    public string $name;
    public string $description;
    public float $amount;
    public int $intervalCount;
    public int $active;

    public function __construct(public Package $package)
    {
        $this->productId = $package->stripe_product_id;
        $this->priceId = $package->stripe_price_id;
        $this->name = $package->name;
        $this->description = $package->description;
        $this->amount = $package->price;
        $this->intervalCount = $package->duration;
        $this->active = $package->is_active;
    }

    public function getPackage(): Package { return $this->package; }
    public function getProductId(): string { return $this->productId; }
    public function getPriceId(): string { return $this->priceId; }
    public function getName(): string { return $this->name; }
    public function getDescription(): ?string { return $this->description; }
    public function getAmount(): float { return $this->amount; }
    public function getIntervalCount(): int { return $this->intervalCount; }
    public function getActive(): bool { return $this->active; } 
}
