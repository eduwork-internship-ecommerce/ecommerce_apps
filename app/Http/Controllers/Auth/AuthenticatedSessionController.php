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
        
        // --- LOGIKA PENGALIHAN DITAMBAHKAN DI SINI ---
        
        // 1. Dapatkan pengguna yang baru saja login
        $user = Auth::user();

        // 2. Cek peran pengguna
        if ($user && $user->role === 'admin') {
            // Arahkan admin ke halaman /admin
            return redirect()->intended('/admin');
        }

        // 3. Pengguna biasa diarahkan ke rute 'home' default
        return redirect()->intended(route('home', absolute: false));
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
