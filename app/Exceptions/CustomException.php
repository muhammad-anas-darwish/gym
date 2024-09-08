<?php

namespace App\Exceptions;

use App\Traits\ApiResponses;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CustomException extends Exception
{
    protected $message;
    protected $status;
    protected $context;

    public function __construct(
        string $message = 'An error occurred', 
        int $status = Response::HTTP_INTERNAL_SERVER_ERROR, 
        array $context = []
    ) {
        $this->message = $message;
        $this->status = $status;
        $this->context = $context;

        parent::__construct($this->message, $this->status);
        $this->logError(); // Log the error when the exception is thrown
    }

    protected function logError(): void
    {
        Log::error($this->message, [
            'status' => $this->status,
            'context' => $this->context,
            'exception' => $this, // Include the exception details
        ]);
    }
}