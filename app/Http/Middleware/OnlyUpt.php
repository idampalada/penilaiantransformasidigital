<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyUpt
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

    // TIM PENILAI boleh lewat walau tidak punya unit
    if (str_contains($roleName, 'timpenilai')) {
        return $next($request);
    }

    // USER biasa harus punya unit
    if (!$user->unit) {
        abort(403, 'User harus memiliki unit.');
    }

    // hanya UPT
    if ($user->unit->jenis !== 'UPT') {
        abort(403, 'Akses hanya untuk UPT atau Super Admin');
    }

    return $next($request);
}
}
