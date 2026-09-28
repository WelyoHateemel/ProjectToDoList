<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = strtolower(trim(auth()->user()->role ?? ''));
        $userRole = str_replace([' ', '_', '-'], '', $userRole);

        // Normalize roles argument (e.g. 'role' -> 'rolemanager' or 'role')
        $normalizedRoles = array_map(function ($r) {
            $nr = strtolower(trim($r));
            return str_replace([' ', '_', '-'], '', $nr);
        }, $roles);

        // Accept rolemanager or role as rolemanager
        if ($userRole === 'role') {
            $userRole = 'rolemanager';
        }

        if (!in_array($userRole, $normalizedRoles)) {
            abort(403, 'Akses tidak diizinkan untuk peran Anda.');
        }

        return $next($request);
    }
}
