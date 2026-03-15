<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware to ensure only logged-in admins can access admin routes.
 *
 * Logic:
 * - Check session key 'admin_logged_in'
 * - If missing or false, redirect to route 'admin.login'
 * - Otherwise allow request to proceed
 */
class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // If the admin session flag is not present or false, redirect to admin login
       if (! session('admin_logged_in') && !$request->routeIs('admin.login')) {
    return redirect()->route('admin.login');
}

        // Admin is logged in, continue processing the request
        return $next($request);
    }
}
