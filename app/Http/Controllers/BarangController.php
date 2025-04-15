<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Ruangan;
use App\Models\Merk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::paginate(10); // Menggunakan pagination untuk performa lebih baik
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();
        $merk = Merk::all();

        return view('barang.index', compact('barang', 'kategori', 'ruangan', 'merk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();
        $merk = Merk::all();

        // Generate kode barang otomatis
        $lastBarang = Barang::latest('kode_barang')->first();
        $newKodeBarang = $lastBarang ? 'BRG' . str_pad((int) substr($lastBarang->kode_barang, 3) + 1, 3, '0', STR_PAD_LEFT) : 'BRG001';

        return view('barang.create', compact('kategori', 'ruangan', 'merk', 'newKodeBarang'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|unique:barang,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'kode_merk' => 'required|exists:merk,kode_merk',
            'kode_kategori' => 'required|exists:kategori,kode_kategori',
            'kode_ruangan' => 'required|exists:ruangan,kode_ruangan',
            'kondisi' => 'required|in:baik,rusak,hilang',
            'deskripsi' => 'nullable|string',
            'photo_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan file foto barang jika ada
        if ($request->hasFile('photo_barang')) {
            $validatedData['photo_barang'] = $request->file('photo_barang')->storeAs('barang_photos', time() . '.' . $request->file('photo_barang')->extension(), 'public');
        }

        Barang::create($validatedData);

        return redirect()->route('Barang.index')->with('success', 'Barang berhasil ditambahkan!');
    }

    public function delete($kode_barang)
    {
        $barang = Barang::where('kode_barang', $kode_barang)->firstOrFail();

        if ($barang->photo_barang) {
            Storage::disk('public')->delete($barang->photo_barang);
        }

        $barang->delete();

        return redirect()->route('Barang.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function invoice()
    {
        $barang = Barang::paginate(10); // Menggunakan pagination untuk performa lebih baik
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();
        $merk = Merk::all();

        return view('barang.invoice', compact('barang', 'kategori', 'ruangan', 'merk'));
    }
}
