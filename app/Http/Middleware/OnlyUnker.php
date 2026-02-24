<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyUnker
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

        // hanya UNKER
        if ($user->unit->jenis !== 'UNKER') {
            abort(403, 'Akses hanya untuk UNKER atau Super Admin');
        }

        return $next($request);
    }
}
