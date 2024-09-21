<?php 

namespace App\DTOs;

use App\Enums\CouponDuration;
use App\Exceptions\CustomException;
use Symfony\Component\HttpFoundation\Response;

class CouponDTO
{
    public string $couponCode;
    public float $percentOff;
    public string $duration;
    public ?int $durationInMonths;

    public function __construct(string $couponCode, float $percentOff, string $duration, ?int $durationInMonths = null, ?string $stripeId = null)
    {
        $this->couponCode = $couponCode;
        $this->percentOff = $percentOff;
        $this->duration = $duration;
        $this->durationInMonths = $durationInMonths;
    }

    public static function fromArray(array $data): self
    {
        self::validateDuration($data['duration'], $data['duration_in_months'] ?? null);

        return new self(
            $data['coupon_code'],
            $data['percent_off'],
            $data['duration'],
            $durationInMonths ?? null,
        );
    }

    private static function validateDuration(string $duration, ?int $durationInMonths): void
    {
        if ($duration === CouponDuration::REPEATING->value && is_null($durationInMonths)) {
            throw new CustomException('You should fill duration in months.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
