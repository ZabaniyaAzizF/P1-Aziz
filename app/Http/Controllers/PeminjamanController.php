<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Books;
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
    
        // Return the view with the peminjaman data
        return view('peminjaman.index', compact('peminjamans'));
    }    

    public function indexMember()
    {
        // Get the authenticated user
        $user = auth()->user();
    
        // Get peminjaman data for the authenticated user only
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
        $book = Books::find($kode_books);
    
        if (!$user || !$book) {
            return redirect()->back()->withErrors('User atau Buku tidak ditemukan.');
        }
    
        if ($user->saldo < $book->harga) {
            return redirect()->back()->withErrors('Saldo tidak cukup untuk melakukan peminjaman.');
        }
    
        DB::beginTransaction();
    
        try {
            $user->saldo -= $book->harga;
    
            // dd($user->saldo); // Untuk test
    
            $user->save();
    
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => Str::uuid()->toString(),
                'user_id' => $validated['user_id'],
                'kode_books' => $kode_books,
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'lunas',
            ]);
    
            DB::commit();
    
            return redirect()->route('Peminjaman.member.index')->with('success', 'Peminjaman berhasil dilakukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
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
        // Kamu bisa menambahkan logic untuk menampilkan invoice peminjaman
        return view('peminjaman.invoice');
    }
}
