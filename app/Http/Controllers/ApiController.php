<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    protected function successResponse(
        $data,
        string $status = 'success',
        string $message = '',
        int $code = Response::HTTP_OK,
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function errorResponse(
        int $code,
        string $status = 'error',
        string $message = '',
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $code);
    }
}
