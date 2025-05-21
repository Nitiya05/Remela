<?php

namespace App\Http\Middleware;

use Closure;

class NoCacheHeaders
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $response->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
            'X-Frame-Options' => 'DENY', // Prevent clickjacking
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
