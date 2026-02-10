<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyUnor
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // belum login
        if (!$user) {
            abort(403);
        }

        // ✅ SUPERADMIN BOLEH LEWAT
        if ($user->role_id === 1) {
            return $next($request);
        }

        // user harus punya unit
        if (!$user->unit) {
            abort(403);
        }

        // hanya UNOR
        if ($user->unit->jenis !== 'UNOR') {
            abort(403, 'Akses hanya untuk UNOR atau Super Admin');
        }

        return $next($request);
    }
}
