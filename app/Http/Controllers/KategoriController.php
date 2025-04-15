<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
    }

    /**
     * Store or Update a kategori
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        if ($request->kategori_id) {
            // UPDATE Kategori berdasarkan ID
            $kategori = Kategori::findOrFail($request->kategori_id);
            $kategori->update([
                'nama_kategori' => $validated['nama_kategori'],
            ]);

            return redirect()->route('Kategori.index')->with('success', 'Kategori berhasil diperbarui.');
        } else {
            // Gunakan autonumber untuk kode_kategori
            $validated['kode_kategori'] = autonumber('kategori', 'kode_kategori', 3, 'KTG');

            // INSERT kategori baru
            Kategori::create($validated);
            return redirect()->route('Kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
        }
    }

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return response()->json($kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('Kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $kategori = Kategori::all();
        return view('kategori.invoice', compact('kategori'));
    }
}
