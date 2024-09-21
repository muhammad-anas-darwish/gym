<?php

namespace App\Exceptions;

use Exception;
use Stripe\Exception\ApiErrorException;

class StripeException extends CustomException
{
    public static function CouponCreationException(Exception $e): StripeException
    {
        if ($e instanceof ApiErrorException) {
            if ($e->getStripeCode() === 'resource_already_exists') {
                return new self('Failed to create coupon. ' . $e->getMessage(), $e->getHttpStatus());
            }
            
            return new self('Failed to create coupon. Please try again later.', $e->getHttpStatus());
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
