<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $author = Author::all();
        return view('author.index', compact('author'));
    }

    /**
     * Store or Update a author
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_author' => 'required|string|max:255',
        ]);

        if ($request->author_id) {
            // UPDATE author berdasarkan ID
            $author = Author::findOrFail($request->author_id);
            $author->update([
                'nama_author' => $validated['nama_author'],
            ]);

            return redirect()->route('Author.index')->with('success', 'author berhasil diperbarui.');
        } else {
            // Gunakan autonumber untuk kode_author
            $validated['kode_author'] = autonumber('author', 'kode_author', 3, 'AUT');

            // INSERT author baru
            Author::create($validated);
            return redirect()->route('Author.index')->with('success', 'author berhasil ditambahkan.');
        }
    }

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return response()->json($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();
        return redirect()->route('Author.index')->with('success', 'author berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $author = Author::all();
        return view('Author.invoice', compact('author'));
    }
}
