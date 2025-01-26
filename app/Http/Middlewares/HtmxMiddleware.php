<?php

namespace App\Http\Middlewares;

use Barryvdh\Debugbar\LaravelDebugbar;
use Closure;
use Illuminate\Http\Request;

class HtmxMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        // Disable Laravel debugbar for HTMX requests
        if($request->headers->has('Hx-Request') && app()->has(LaravelDebugbar::class)) {
            app(LaravelDebugbar::class)->disable();
        }

        return $next($request);
    }

}
