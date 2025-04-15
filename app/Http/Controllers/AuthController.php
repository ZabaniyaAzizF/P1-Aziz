<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        // Jika pengguna sudah login, arahkan ke dashboard
        if (Auth::check()) {
            return redirect()->route('Dashboard');
        }
    
        // Mengatur header cache
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }    

    public function login_proses(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ], [
            'email.required'    => 'Email wajib diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        $data = [
            'email'    => $request->email,
            'password' => $request->password
        ];

        // Menambahkan parameter 'remember' jika checkbox diaktifkan
        $remember = $request->has('remember');

        if (Auth::attempt($data, $remember)) {
            return redirect()->route('Dashboard'); // Pastikan rute ini sesuai
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Anda Salah');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}