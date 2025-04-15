<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengajuan = Pengajuan::with('meja')->get();
        return view('pengajuan.index', compact('pengajuan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newKodePengajuan = 'PGJ-' . now()->format('YmdHis'); // Generate kode unik
        $meja = Meja::all(); // Ambil data meja dari database

        return view('pengajuan.create', compact('newKodePengajuan', 'meja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil array data pengajuan
        $pengajuans = $request->input('barang'); // Ambil semua pengajuan dalam array

        // Validasi data
        $request->validate([
            'barang.*.nama_barang' => 'required|string|max:255', // Validasi setiap nama_barang
            'barang.*.kode_meja' => 'required|exists:meja,kode_meja', // Pastikan meja valid
        ]);

        // Loop untuk menyimpan setiap pengajuan
        foreach ($pengajuans as $pengajuan) {
            // Tambahkan nama pengaju otomatis dari data login
            $pengajuan['nama_pengaju'] = Auth::user()->name;

            // Generate kode_pengajuan unik (6 karakter)
            $kodePengajuan = strtoupper(Str::random(6));

            // Simpan data pengajuan
            Pengajuan::create([
                'kode_pengajuan' => $kodePengajuan,
                'nama_pengaju' => $pengajuan['nama_pengaju'],
                'nama_barang' => $pengajuan['nama_barang'],
                'kode_meja' => $pengajuan['kode_meja'],
                'status' => 'Pending', // Status default
            ]);
        }

        return redirect()->route('Pengajuan.index')->with('success', 'Pengajuan berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_pengajuan)
    {
        $pengajuan = Pengajuan::where('kode_pengajuan', $kode_pengajuan)->firstOrFail();
        $meja = Meja::all();

        return view('pengajuan.edit', compact('pengajuan', 'meja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_pengajuan)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_meja' => 'required|exists:meja,kode_meja',
        ]);

        Pengajuan::where('kode_pengajuan', $kode_pengajuan)->update([
            'nama_barang' => $request->nama_barang,
            'kode_meja' => $request->kode_meja,
        ]);

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($kode_pengajuan)
    {
        $pengajuan = Pengajuan::findOrFail($kode_pengajuan);
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with('success', 'Pengajuan berhasil dihapus!');
    }

    /**
     * Approve the specified pengajuan.
     */
    public function approve($kode_pengajuan)
    {
        $pengajuan = Pengajuan::findOrFail($kode_pengajuan);

        // Perbarui status menjadi "Disetujui"
        $pengajuan->status = 'Disetujui';
        $pengajuan->save();

        return redirect()->route('Pengajuan.index')->with('success', 'Pengajuan berhasil disetujui!');
    }

    /**
     * Reject the specified pengajuan.
     */
    public function reject($kode_pengajuan)
    {
        $pengajuan = Pengajuan::findOrFail($kode_pengajuan);

        // Perbarui status menjadi "Ditolak"
        $pengajuan->status = 'Ditolak';
        $pengajuan->save();

        return redirect()->route('Pengajuan.index')->with('success', 'Pengajuan berhasil ditolak!');
    }
}
