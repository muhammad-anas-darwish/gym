<?php

namespace App\Exceptions;

use Exception;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\InvalidRequestException;

class StripeException extends CustomException
{
    public static function CouponCreationException(Exception $e): StripeException
    {
        if ($e instanceof InvalidRequestException) {
            if ($e->getStripeCode() === 'resource_already_exists') {
                return new self('Failed to create coupon. ' . $e->getMessage(), $e->getHttpStatus());
            }

            if ($e->getStripeParam() === 'redeem_by' && str_contains($e->getMessage(), 'in the past')) {
                return new self('Failed to create coupon. The redeem_by date must be in the future.', $e->getHttpStatus());
            }

            return new self('Failed to create coupon. The parameter ' . $e->getStripeParam() . ' is invalid: ' . $e->getMessage(), 422);
        }

        return new self('Failed to create coupon. Please try again later.', 500);
    }

    public static function CouponDeletionException(Exception $e): StripeException
    {
        if ($e instanceof ApiErrorException) {            
            return new self('Failed to delete coupon. Please try again later.', $e->getHttpStatus());
        }

        return new self('Failed to delete coupon. Please try again later.', 500);
    }
}
