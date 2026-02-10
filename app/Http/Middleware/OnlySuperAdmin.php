<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlySuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // belum login
        if (!$user) {
            abort(403);
        }

        // role superadmin (role_id = 1)
        if ($user->role_id !== 1) {
            abort(403, 'Akses hanya untuk Super Admin');
        }

        return $next($request);
    }
}
