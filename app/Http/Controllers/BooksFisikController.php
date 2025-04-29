<?php

namespace App\Http\Controllers;

use App\Models\Books_fisik;
use App\Models\Kategori;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksFisikController extends Controller
{
    public function index()
    {
        $books = Books_fisik::all();
        $kategori = Kategori::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $book = null;

        return view('books_fisik.index', compact('books', 'kategori', 'authors', 'publishers', 'book'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_books_fisik' => 'required|string|unique:books_fisik,kode_books_fisik|max:8',
            'title' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:6',
            'kode_author' => 'required|string|max:6',
            'kode_publisher' => 'required|string|max:6',
            'harga' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        $photoPath = $request->hasFile('photo') ? $request->file('photo')->store('covers', 'public') : null;
        $fileBookPath = $request->hasFile('file_book') ? $request->file('file_book')->store('books', 'public') : null;
    
        $book = Books_fisik::create([
            'kode_books_fisik' => $request->kode_books_fisik,
            'title' => $request->title,
            'kode_kategori' => $request->kode_kategori,
            'kode_author' => $request->kode_author,
            'kode_publisher' => $request->kode_publisher,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'isbn' => $request->isbn,
            'photo' => $photoPath,
        ]);
    
        return redirect()->route('Books_fisik.index')->with('success', 'Buku berhasil ditambahkan.');
    }
    
    public function update(Request $request, $id)
    {
        $book = Books_fisik::findOrFail($id);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:6',
            'kode_author' => 'required|string|max:6',
            'kode_publisher' => 'required|string|max:6',
            'harga' => 'required|numeric',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        $data = [
            'title' => $request->title,
            'kode_kategori' => $request->kode_kategori,
            'kode_author' => $request->kode_author,
            'kode_publisher' => $request->kode_publisher,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'isbn' => $request->isbn,
        ];
    
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($book->photo) {
                Storage::disk('public')->delete($book->photo);
            }
            $data['photo'] = $request->file('photo')->store('covers', 'public');
        }
    
    
        $book->update($data);
    
        return redirect()->route('Books_fisik.index')->with('success', 'Buku berhasil diperbarui.');
    }
    
    public function delete($id)
    {
        $book = Books_fisik::findOrFail($id);
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();

        return redirect()->route('Books_fisik.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function invoice()
    {
        $books = Books_fisik::all();
        $kategori = Kategori::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('books_fisik.invoice', compact('books', 'kategori', 'authors', 'publishers'));
    }
}

