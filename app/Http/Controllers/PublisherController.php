<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $publisher = Publisher::all();
        return view('publisher.index', compact('publisher'));
    }

    /**
     * Store or Update a publisher
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_publisher' => 'required|string|max:255',
        ]);

        if ($request->publisher_id) {
            // UPDATE publisher berdasarkan ID
            $publisher = Publisher::findOrFail($request->publisher_id);
            $publisher->update([
                'nama_publisher' => $validated['nama_publisher'],
            ]);

            return redirect()->route('Publisher.index')->with('success', 'publisher berhasil diperbarui.');
        } else {
            // Gunakan autonumber untuk kode_publisher
            $validated['kode_publisher'] = autonumber('publisher', 'kode_publisher', 3, 'PUB');

            // INSERT publisher baru
            Publisher::create($validated);
            return redirect()->route('Publisher.index')->with('success', 'publisher berhasil ditambahkan.');
        }
    }

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $publisher = Publisher::findOrFail($id);
        return response()->json($publisher);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->delete();
        return redirect()->route('Publisher.index')->with('success', 'publisher berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $publisher = Publisher::all();
        return view('publisher.invoice', compact('publisher'));
    }
}
