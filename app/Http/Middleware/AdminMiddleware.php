<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isAdmin() ) {
            return response()->json([
                'message' => 'Need authorization',
            ], 403);
        }

        return $next($request);
    }
}
