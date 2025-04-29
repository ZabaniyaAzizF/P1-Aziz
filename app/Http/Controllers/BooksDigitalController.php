<?php

namespace App\Http\Controllers;

use App\Models\Books_digital;
use App\Models\Kategori;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksDigitalController extends Controller
{
    public function index()
    {
        $books = Books_digital::all();
        $kategori = Kategori::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $book = null;

        return view('books_digital.index', compact('books', 'kategori', 'authors', 'publishers', 'book'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_books_digital'     => 'nullable|string|max:8',
            'title'          => 'required|string|max:255',
            'kode_kategori'  => 'required|string|max:6',
            'kode_author'    => 'required|string|max:6',
            'kode_publisher' => 'required|string|max:6',
            'harga'          => 'required|numeric',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_book'      => 'nullable|mimes:pdf',
        ]);

        // Upload photo cover
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/uploads/books/photo'), $photoName);
            $validated['photo'] = $photoName;
        }

        // Upload file PDF buku
        if ($request->hasFile('file_book')) {
            $pdf = $request->file('file_book');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('storage/uploads/books/pdf'), $pdfName);
            $validated['file_book'] = $pdfName;
        }

        if ($request->kode_books_digital && Books_digital::find($request->kode_books_digital)) {
            // UPDATE
            $book = Books_digital::findOrFail($request->kode_books_digital);
            $book->update($validated);
            return redirect()->route('Books_digital.index')->with('success', 'Buku berhasil diperbarui.');
        } else {
            // INSERT
            $validated['kode_books_digital'] = autonumber('books_digital', 'kode_books_digital', 5, 'BOK');
            Books_digital::create($validated);
            return redirect()->route('Books_digital.index')->with('success', 'Buku berhasil ditambahkan.');
        }
    }
    
    public function update(Request $request, $id)
    {
        $book = Books_digital::findOrFail($id);
    
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
    
        return redirect()->route('Books_digital.index')->with('success', 'Buku berhasil diperbarui.');
    }
    
    public function delete($id)
    {
        $book = Books_digital::findOrFail($id);
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();

        return redirect()->route('Books_digital.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function invoice()
    {
        $books = Books_digital::all();
        $kategori = Kategori::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('books_digital.invoice', compact('books', 'kategori', 'authors', 'publishers'));
    }
}

