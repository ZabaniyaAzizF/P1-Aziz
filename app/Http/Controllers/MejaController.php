<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Meja;
use App\Models\Merk;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meja = Meja::all();
        $barang = Barang::all();
        return view('meja.index', compact('meja', 'barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barang = Barang::all();
        $kategori = Kategori::all();
        $ruangan = Ruangan::all();
        $merk = Merk::all();

        return view('meja.create', compact('barang', 'kategori', 'ruangan', 'merk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all()); 

        $request->validate([
            'kode_meja' => 'required|unique:meja,kode_meja',
            'nama_meja' => 'required|string|max:255',
            'kode_barang' => 'required|string', // Barang harus dipilih
        ]);
    
        // Simpan meja baru
        $meja = Meja::create([
            'kode_meja' => $request->kode_meja,
            'nama_meja' => $request->nama_meja,
        ]);
    
        // Simpan barang ke dalam pivot table
        $kodeBarangList = explode(',', $request->kode_barang);
        $meja->barang()->attach($kodeBarangList); // Laravel otomatis menyimpan di tabel pivot
    
        // Update status barang yang dipilih menjadi 1 (tidak tersedia)
        Barang::whereIn('kode_barang', $kodeBarangList)->update(['status' => 1]);
    
        return redirect()->route('Meja.index')->with('success', 'Meja berhasil ditambahkan dengan barang yang dipilih.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //
    }
}
