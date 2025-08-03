<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;

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
                    return redirect()->intended('/administrator');
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

    public function showRegisterForm()
    {
        $data = [
            'title' => 'Register',
        ];
        return view('auth.register', $data);
    }

    public function register(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Ambil data input
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        // Generate token verifikasi (acak 5 digit)
        $token = rand(10000, 99999);

        // Buat user baru dengan status 'pending'
        $user = new User;
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->role = 'customer';
        $user->status = 'pending';
        $user->remember_token = md5($token); // Bisa disimpan di kolom token_verifikasi jika ada
        $user->save();

        // Siapkan data untuk email
        $data = [
            'name' => $name,
            'verification_code' => md5($token),
        ];

        // Kirim email verifikasi
        Mail::to($email)->send(new RegisterMail($data));

        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Registrasi berhasil. Silakan cek email untuk verifikasi.');
    }

    public function verify($token)
    {
        // Cari user berdasarkan token
        $user = User::where('remember_token', $token)->first();
        if ($user) {
            // generate token baru 
            $token = rand(10000, 99999);
            // Update status user menjadi 'active'
            $user->status = 'active';
            $user->remember_token = md5($token);
            $user->email_verified_at = now();
            $user->save();

            // Redirect ke halaman login dengan pesan sukses
            return redirect('/login')->with('success', 'Akun Anda telah berhasil diverifikasi. Silakan login.');
        } else {
            // Redirect ke halaman login dengan pesan error
            return redirect('/login')->with('alert', 'Token verifikasi tidak valid.');
        }
    }


    public function AdministratorShowLoginForm()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('administrator.auth.login_administrator', $data);
    }
}
