<?php

namespace App\Exceptions;

use Exception;

class ServiceException extends CustomException
{
    public static function CouponCreationException(Exception $exception): ServiceException
    {
        return new self('Failed to create coupon. Database error: ' . $exception->getMessage(). '.', $exception->getCode());
    }

    public static function CouponDeletionException(Exception $exception): ServiceException
    {
        return new self('Failed to delete coupon. Database error: ' . $exception->getMessage(). '.', $exception->getCode(), [
            'error' => $exception->getMessage(),
        ]);
    }
}
