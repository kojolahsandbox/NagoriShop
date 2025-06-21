<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('auth.login', $data);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek status user
            if ($user->status === 'pending') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun belum terverifikasi, silakan cek email Anda.',
                ]);
            }

            if ($user->status === 'nonactive') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda nonaktif, silakan hubungi admin.',
                ]);
            }

            $request->session()->regenerate();

            // Optional: redirect sesuai role
            switch (Auth::user()->role) {
                case 'administrator':
                    return redirect()->intended('/admin');
                case 'seller':
                    return redirect()->intended('/seller');
                case 'customer':
                    return redirect()->intended('/');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Login gagal. Cek email dan password.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
