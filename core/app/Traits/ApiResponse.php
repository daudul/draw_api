<?php

namespace App\Traits;

trait ApiResponse
{
    public static function successWithData(string $message, object $data, int $httpStatusCode)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $httpStatusCode);
    }

    public static function successMessage(string $message, int $httpStatusCode)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], $httpStatusCode);
    }

    public static function error(string $message, int $httpStatusCode)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $httpStatusCode);
    }

    public static function validatedError(array $message = [], int $httpStatusCode)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $httpStatusCode);
    }
}
