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

        // ✅ SUPER ADMIN (role_id = 1)
        if ($user->role_id === 1) {
            return redirect('/unor');
        }

        // ✅ BERDASARKAN JENIS UNIT
        if ($user->unit?->jenis === 'UNOR') {
            return redirect('/unor');
        }

        if ($user->unit?->jenis === 'UNKER') {
            return redirect('/unker');
        }

        if ($user->unit?->jenis === 'UPT') {
            return redirect('/upt');
        }

        // fallback (kalau user tidak punya unit)
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
