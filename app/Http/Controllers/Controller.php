<?php

namespace App\Http\Controllers;

use ArrayObject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    const LIMIT = 12;

    protected function success(
        mixed $data = null,
        array $metadata = [],
        int $code = 200,
        int $httpCode = 200
    ): JsonResponse {
        return response()->json([
            'code' => $code,
            'data' => is_null($data) ? new ArrayObject() : $data,
            '_metadata' => empty($metadata) ? new ArrayObject() : $metadata,
        ], $httpCode);
    }

    protected function failure(
        string $message = 'system.error',
        int $code = 500,
        int $httpCode = 500
    ): JsonResponse {
        return response()->json([
            'code' => $code,
            'message' => $message,
        ], $httpCode);
    }

    protected function notFound(
        string $message = 'entity_not_found',
    ): JsonResponse {
        return $this->failure(
            $message,
            404,
            404,
        );
    }
}
