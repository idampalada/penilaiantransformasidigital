<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user->role->name;

        // 🔥 1. Kalau tim penilai → ke halaman pilih unit
        if (str_contains($role, 'timpenilai')) {
            return redirect('/unit');
        }

        // 🔥 2. Kalau user biasa → pakai unit dari DB
        $jenis = strtoupper($user->unit?->jenis ?? '');

        if ($jenis === 'UNOR') {
            return redirect('/unor');
        }

        if ($jenis === 'UNKER') {
            return redirect('/unker');
        }

        if ($jenis === 'UPT') {
            return redirect('/upt');
        }

        // 🔥 3. Default fallback
        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}