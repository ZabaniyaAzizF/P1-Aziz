<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Books_fisik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Menampilkan semua peminjaman
     */
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->get();
    
        return view('peminjaman.admin', compact('peminjamans'));
    }    

    public function indexMember()
    {
        $user = auth()->user();
    
        $peminjamans = Peminjaman::with(['user', 'buku'])
                                 ->where('user_id', $user->id)
                                 ->get();
    
        return view('peminjaman.index', compact('peminjamans'));
    }    

    /**
     * Menyimpan data peminjaman
     */
    public function store(Request $request, $kode_books)
    {  
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);
        
        $user = User::find($validated['user_id']);
        $book = Books_fisik::find($kode_books);
        
        if (!$user || !$book) {
            return redirect()->back()->withErrors('User atau Buku tidak ditemukan.');
        }
        
        if ($user->saldo < $book->harga) {
            return redirect()->back()->withErrors('Saldo tidak cukup untuk melakukan peminjaman.');
        }
        
        $lastPeminjaman = Peminjaman::orderBy('kode_peminjaman', 'desc')->first();
        if ($lastPeminjaman) {
            $lastNumber = (int) substr($lastPeminjaman->kode_peminjaman, 3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $kodePeminjaman = 'PMJ' . str_pad($newNumber, 7, '0', STR_PAD_LEFT);
        
        // Kurangi saldo user
        $user->saldo -= $book->harga;
        $userUpdated = $user->save();
        
        if (!$userUpdated) {
            return redirect()->back()->withErrors('Gagal memperbarui saldo user.');
        }
        
        // Buat peminjaman
        $peminjaman = Peminjaman::create([
            'kode_peminjaman' => $kodePeminjaman,
            'user_id' => $validated['user_id'],
            'kode_books' => $kode_books,
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'status' => 'lunas',
        ]);
        
        if (!$peminjaman) {
            return redirect()->back()->withErrors('Gagal membuat data peminjaman. Silakan hubungi admin.');
        }
        
        return redirect()->route('Peminjaman.member.index')->with('success', 'Peminjaman berhasil dilakukan.');         
    }      

    /**
     * Mengupdate peminjaman
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Update data peminjaman
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->tanggal_kembali = $validated['tanggal_kembali'];
        $peminjaman->save();

        return redirect()->route('Peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Menghapus data peminjaman
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('Peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    /**
     * Menampilkan invoice peminjaman
     */
    public function invoice()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->get();
    
        // Return the view with the peminjaman data
        return view('peminjaman.invoice', compact('peminjamans'));
    }
}
