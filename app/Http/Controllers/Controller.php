<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    final protected function success($result, int $code = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
        ];
        return response()->json($response, $code);
    }
    final protected function error($error, int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => $error,
        ];

        return response()->json($response, $code);
    }
}
