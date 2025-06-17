<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Gunakan helper method yang baru kita buat
        if (auth()->check() && auth()->user()->isAdmin()) { // Cek jika levelnya admin atau lebih tinggi
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki hak akses admin.');
    }
}
