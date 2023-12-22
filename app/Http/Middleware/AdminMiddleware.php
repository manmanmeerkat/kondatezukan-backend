<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    // AdminMiddleware.php
    public function handle($request, Closure $next)
    {
        if (auth('api')->check() && auth('api')->user()->role === 'admin') {
        } else {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        return $next($request);
    }
}
