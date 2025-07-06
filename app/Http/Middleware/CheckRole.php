<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $userRole = strtolower($user->role);
        $allowedRoles = array_map('strtolower', $roles);

        Log::info("Masuk ke middleware CheckRole. User role: {$userRole}, Allowed: " . implode(',', $allowedRoles));

        // Ubah pengecekan jadi case insensitive biar aman
        if (!in_array(strtolower($user->role), array_map('strtolower', $roles))) {
            Log::warning("Unauthorized access attempt. User role: {$userRole}, Required roles: " . implode(',', $allowedRoles));
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}