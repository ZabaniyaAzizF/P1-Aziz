<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ruangan = Ruangan::all();
        return view('ruangan.index', compact('ruangan'));
    }

    /**
     * Store or Update a kategori
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|string|max:255',
        ]);

        if ($request->ruangan_id) {
            // UPDATE Kategori berdasarkan ID
            $ruangan = Ruangan::findOrFail($request->ruangan_id);
            $ruangan->update([
                'nama_ruangan' => $validated['nama_ruangan'],
            ]);

            return redirect()->route('Ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
        } else {
            // Gunakan autonumber untuk kode_ruangan
            $validated['kode_ruangan'] = autonumber('ruangan', 'kode_ruangan', 3, 'RUN');

            // INSERT kategori baru
            Ruangan::create($validated);
            return redirect()->route('Ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
        }
    }

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return response()->json($ruangan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();
        return redirect()->route('Ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $ruangan = Ruangan::all();
        return view('ruangan.invoice', compact('ruangan'));
    }
}
