<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyUnor
{
public function handle(Request $request, Closure $next)
{
    $user = auth()->user();

    if (!$user) {
        abort(403);
    }

    $roleName = $user->role->name ?? null;

    // SUPERADMIN boleh lewat
    if ($roleName === 'superadmin') {
        return $next($request);
    }

    // TIM PENILAI boleh tanpa unit
    if (str_contains($roleName, 'timpenilai')) {
        return $next($request);
    }

    // USER biasa wajib punya unit
    if (!$user->unit) {
        abort(403, 'User harus memiliki unit.');
    }

    // hanya UNOR
    if ($user->unit->jenis !== 'UNOR') {
        abort(403, 'Akses hanya untuk UNOR atau Super Admin');
    }

    return $next($request);
}
}
