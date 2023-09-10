<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomCorsMiddleware
{
    public function handle($request, Closure $next)
    {
        // CORSヘッダーを設定
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
        return $response;
    }
}
