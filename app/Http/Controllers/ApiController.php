<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    protected function successResponse(
        string $status = 'success',
        string $message = '',
        $data,
        int $code = Response::HTTP_OK,
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function errorResponse(
        string $status = 'error',
        string $message = '',
        int $code,
    ): JsonResponse {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ], $code);
    }
}
