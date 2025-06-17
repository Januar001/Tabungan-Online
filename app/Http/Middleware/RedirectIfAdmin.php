<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_admin) {
            // Jika ya, alihkan langsung ke dasbor admin
            return redirect()->route('admin.dashboard');
        }

        // Jika dia bukan admin, biarkan dia melanjutkan ke tujuan awalnya
        return $next($request);
    }
}
