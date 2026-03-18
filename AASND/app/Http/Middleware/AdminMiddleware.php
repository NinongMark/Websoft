<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Blocks admins from accessing customer-only routes
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Block admins from accessing these routes
        if ($request->user() && $request->user()->isAdmin()) {
            abort(403, 'Access denied. Admins cannot place orders.');
        }

        return $next($request);
    }
}

