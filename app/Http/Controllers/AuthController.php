<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Books;
use App\Models\Books_digital;
use App\Models\Books_fisik;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Promo;
use App\Models\Peminjaman;
use App\Models\Top_ups;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return view('dashboard');
        }

        // Jika belum login, tampilkan form login
        return view('auth.login');
    }

    public function login_proses(Request $request)
    {
        // Validasi input
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

        $remember = $request->has('remember');

        if (Auth::attempt($data, $remember)) {
            return redirect()->route('Dashboard');
        } else {
            return redirect()->route('login')->with('failed', 'Email atau Password Anda Salah');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'telepon'  => 'required|min:12'
        ], [
            'name.required'         => 'Nama wajib diisi',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Format email tidak valid',
            'email.unique'          => 'Email sudah digunakan',
            'telepon.required'      => 'Telepon wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.min'          => 'Password minimal 6 karakter',
            'password.confirmed'    => 'Konfirmasi password tidak cocok',
        ]);

        // Simpan user baru
        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->telepon  = $request->telepon;
        $user->password = Hash::make($request->password);
        $user->role     = 'Member'; // default role

        $user->save();

        Auth::login($user);

        return redirect()->route('Dashboard')->with('success', 'Akun berhasil dibuat dan login!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function getData()
    {
        if (auth()->check()) {
            $role = auth()->user()->role;

            if (in_array($role, ['Admin', 'Supervisor', 'Petugas'])) {
                return response()->json([
                    'totalUsers'            => User::count(),
                    'totalBukuFisik'        => Books_digital::count(),
                    'totalBukuDigital'      => Books_fisik::count(),
                    'totalKategori'         => Kategori::count(),
                    'totalPromo'            => Promo::count(),
                ]);
            }

            if ($role === 'Member') {
                $userId = auth()->id();
                return response()->json([
                    'totalPeminjaman'   => Peminjaman::where('user_id', $userId)->count(),
                    'totalPembelian'    => Pembelian::where('user_id', $userId)->count(),
                    'totalSaldo'        => auth()->user()->saldo,
                    'totalTopUp'        => Top_ups::where('user_id', $userId)->count(),
                    'totalPromo'        => Promo::count(),
                ]);
            }

            return response()->json(['message' => 'Akses ditolak'], 403);
        }

        return response()->json(['message' => 'Belum login'], 401);
    }
}
