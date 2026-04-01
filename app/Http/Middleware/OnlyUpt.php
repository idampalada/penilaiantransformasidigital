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
    // HANYA UPT YANG BOLEH AKSES
    // =========================
    if ($user->unit->jenis !== 'UPT') {
        abort(403, 'Akses hanya untuk unit jenis UPT');
    }

    return $next($request);
}
}
