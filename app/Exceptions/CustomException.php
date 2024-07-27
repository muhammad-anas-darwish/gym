<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomException extends Exception
{
    protected $message;
    protected $statusCode;

    public function __construct($message, $statusCode = 400)
    {
        parent::__construct($message, $statusCode);
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function render(): JsonResponse
    {
        return response()->json(['error' => $this->message], $this->statusCode);
    }
}