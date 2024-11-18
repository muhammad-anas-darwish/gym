<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

trait ApiResponses
{
    public function successResponse(
        array|ResourceCollection|AnonymousResourceCollection|JsonResource|Collection|string $data = [],
        int $code = Response::HTTP_OK,
        ?string $message = null,
        ?string $direct = null,
    ): JsonResponse {
        if (is_null($message)) {
            $message = Response::$statusTexts[$code];
        }

        return response()->json([
            "success" => true,
            "code" => $code,
            "direct" => $direct,
            "message" => $message,
            "data" => $data
        ]);
    }

    public function failedResponse(
        ?string $message = null,
        int $code = Response::HTTP_NOT_FOUND,
        ?string $direct = null,
        ?array $data = [],
    ): JsonResponse {
        if (is_null($message)) {
            $message = Response::$statusTexts[$code];
        }

        return response()->json([
            "success" => false,
            "code" => $code,
            "message" => $message,
            "direct" => $direct,
            "data" => $data,
        ], $code);
    }
}
