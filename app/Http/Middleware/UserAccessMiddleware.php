<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Buat ngechek apakah user ada, dan dia admin.
        if (Auth::check() && Auth::user()->isAdmin) {
            return $next($request);
        }
        // Buat ngecheck apakah user ada
        if (Auth::check()) {
            return $next($request);
        }

        return response()->view('errors.401', [
            'message' => 'You must be logged in to access this page.'
        ], 401);
    }
}
