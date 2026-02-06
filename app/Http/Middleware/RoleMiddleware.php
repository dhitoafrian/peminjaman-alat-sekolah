<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * * @param string $role  <-- Kita tambah parameter ini biar bisa dinamis
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek Login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Cek Role (Sesuai parameter di route)
        // Kalau user->role TIDAK SAMA dengan $role yang diminta, tendang.
        if (auth()->user()->role !== $role) {

            // Logika Redirect Pintar:
            // Kalau dia admin nyasar ke halaman user, balikin ke dashboard admin
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard'); // Sesuaikan nama route dashboard adminmu
            }

            // Kalau user biasa nyasar ke halaman admin, balikin ke dashboard user
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
