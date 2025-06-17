<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Gunakan helper method
        if (auth()->check() && auth()->user()->isSuperAdmin()) { // Cek jika levelnya super admin
            return $next($request);
        }

        abort(403, 'Akses ditolak. Fitur ini hanya untuk Super Admin.');
    }
}
