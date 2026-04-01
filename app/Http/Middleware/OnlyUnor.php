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

    // =========================
    // TIM PENILAI (bebas tanpa unit)
    // =========================
    if (str_contains($roleName, 'timpenilai')) {
        return $next($request);
    }

    // =========================
    // SEMUA SELAIN TIM PENILAI WAJIB PUNYA UNIT
    // (termasuk superadmin)
    // =========================
    if (!$user->unit) {
        abort(403, 'User harus memiliki unit.');
    }

    // =========================
    // HANYA UNOR YANG BOLEH AKSES
    // =========================
    if ($user->unit->jenis !== 'UNOR') {
        abort(403, 'Akses hanya untuk unit jenis UNOR');
    }

    return $next($request);
}
}
