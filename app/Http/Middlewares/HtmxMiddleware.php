<?php

namespace App\Http\Middlewares;

use Barryvdh\Debugbar\LaravelDebugbar;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HtmxMiddleware
{

    /**
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Disable Laravel debugbar for HTMX requests
        if($request->headers->has('Hx-Request') && app()->has(LaravelDebugbar::class)) {
            app(LaravelDebugbar::class)->disable();
        }

        return $next($request);
    }

}
