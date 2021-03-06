<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

/**
 * Class ResponseTrait
 * @package App\Traits
 */
trait ResponseTrait
{
    /**
     * @param string $message
     * @param array $details
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(string $message, array $details = [], int $code = 400): JsonResponse
    {
        $response = [
            'is_request_success' => false,
            'error_message' => $message,
            'error_details' => $details
        ];

        return response()->json($response, $code);
    }

    /**
     * @param array $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(array $data = [], int $code = 200): JsonResponse
    {
        $response = [
            'is_request_success' => true,
        ];

        return response()->json($response + $data, $code);
    }
}
