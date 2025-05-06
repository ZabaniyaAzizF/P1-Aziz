<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembelian;
use App\Models\BooksDigital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelians = Pembelian::with(['user', 'buku_digital'])->get();
        return view('pembelian.admin', compact('pembelians'));
    }

    public function indexMember()
    {
        $user = auth()->user();
        $pembelians = Pembelian::with(['user', 'buku_digital'])
            ->where('user_id', $user->id)
            ->get();

        return view('pembelian.index', compact('pembelians'));
    }

    /**
     * Handle payment for the purchase.
     */
    public function bayar(Request $request)
    {
        $request->validate([
            'kode_books_digital' => 'required',
            'harga' => 'required|numeric',
        ]);

        $user = User::find(auth()->id());

        // Cek saldo cukup
        if ($user->saldo < $request->harga) {
            return back()->with('error', 'Saldo tidak cukup untuk melakukan pembayaran.');
        }

        // Generate kode_pembelian
        $lastPembelian = DB::table('pembelian')->orderBy('kode_pembelian', 'desc')->first();
        if ($lastPembelian) {
            $lastNumber = (int)substr($lastPembelian->kode_pembelian, 2);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        $kodePembelian = 'PB' . $newNumber;

        // Kurangi saldo
        $user->saldo -= $request->harga;
        $user->save();

        // Simpan ke tabel pembelian
        Pembelian::create([
            'kode_pembelian' => $kodePembelian,
            'user_id' => $user->id,
            'kode_books_digital' => $request->kode_books_digital,
            'status' => 'lunas',
            'tanggal_beli' => now(),
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil!');
    }
}
