<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau sandi tidak sesuai.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $dashboardRoute = match (Auth::user()->role) {
            User::ROLE_PELAPOR => 'area.pelapor',
            User::ROLE_PEMANTAU => 'area.pemantau',
            User::ROLE_KOORDINATOR => 'area.koordinator',
            default => abort(403),
        };

        return redirect()->intended(route($dashboardRoute));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
