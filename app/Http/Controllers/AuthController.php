<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function register() {

        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'telepon' => 'required|min:12'
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'telepon.required' => 'Telepon wajib diisi',
            'password.min' => 'Telepon minimal 12 karakter',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
    
        // Menyimpan data user baru
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        
        // Atur rolenya sebagai 'Member' (dengan asumsi ada field role)
        $user->role = 'Member';
        
        $user->save();
    
        // Setelah register, langsung login user (opsional)
        Auth::login($user);
    
        return redirect()->route('Dashboard')->with('success', 'Akun berhasil dibuat dan login!');
    }    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}