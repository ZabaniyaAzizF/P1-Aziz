<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $merk = Merk::all();
        return view('merk.index', compact('merk'));
    }

    /**
     * Store or Update a Merk
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_merk' => 'required|string|max:255',
        ]);

        if ($request->merk_id) {
            // UPDATE merk berdasarkan ID
            $merk = Merk::findOrFail($request->merk_id);
            $merk->update([
                'nama_merk' => $validated['nama_merk'],
            ]);

            return redirect()->route('Merk.index')->with('success', 'Merk berhasil diperbarui.');
        } else {
            // Gunakan autonumber untuk kode_Merk
            $validated['kode_merk'] = autonumber('merk', 'kode_merk', 3, 'MRK');

            // INSERT Merk baru
            Merk::create($validated);
            return redirect()->route('Merk.index')->with('success', 'Merk berhasil ditambahkan.');
        }
    }

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $merk = Merk::findOrFail($id);
        return response()->json($merk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $merk = Merk::findOrFail($id);
        $merk->delete();
        return redirect()->route('Merk.index')->with('success', 'Merk berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $merk = Merk::all();
        return view('merk.invoice', compact('merk'));
    }
}
