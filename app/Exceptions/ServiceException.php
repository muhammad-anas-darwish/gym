<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ServiceException extends CustomException
{
    public static function CouponCreationException(Exception $exception): ServiceException
    {
        $statusCode = $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        
        return new self('Failed to create coupon. Database error: ' . $exception->getMessage(). '.', (int)$statusCode);
    }

    public static function CouponDeletionException(Exception $exception): ServiceException
    {
        $statusCode = $exception->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;

        return new self('Failed to delete coupon. Database error: ' . $exception->getMessage(). '.', (int)$statusCode, [
            'error' => $exception->getMessage(),
        ]);
    }
}
