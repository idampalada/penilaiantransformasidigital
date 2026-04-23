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

    // ✅ Ambil role dengan aman
    $role = $user->role->name ?? '';

    // 📝 Logging login sukses
    \Log::info('Login success', [
        'user_id' => $user->id,
        'email' => $user->email,
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    // 🔥 NORMALISASI ROLE (hapus spasi & lowercase)
    $normalizedRole = strtolower(str_replace(' ', '', $role));

    // 🔥 1. Tim penilai → ke halaman pilih unit
    if (str_starts_with($normalizedRole, 'timpenilai')) {
        return redirect('/unit');
    }

    // 🔥 2. Redirect berdasarkan unit (untuk user biasa)
    $jenis = strtoupper($user->unit?->jenis ?? '');

    $allowed = ['UNOR', 'UNKER', 'UPT'];

    if (in_array($jenis, $allowed)) {
        return redirect('/' . strtolower($jenis));
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