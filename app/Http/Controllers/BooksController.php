<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Kategori;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function indexBooks()
    {
        $books = Books::with(['kategori', 'author', 'publisher'])->get();
        $kategoriList = Kategori::all();
        $authorList = Author::all();
        $publisherList = Publisher::all();

        return view('books.index', compact('books', 'kategoriList', 'authorList', 'publisherList'));
    }

    public function indexMember() {
        $books = Books::with(['kategori', 'author', 'publisher'])->get();
        $kategoriList = Kategori::all();
        $authorList = Author::all();
        $publisherList = Publisher::all();

        return view('books.member', compact('books', 'kategoriList', 'authorList', 'publisherList'));
    }

    public function storeBooks(Request $request, $id = null)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'kode_kategori' => 'required|exists:kategori,kode_kategori',
            'kode_author' => 'required|exists:author,kode_author',
            'kode_publisher' => 'required|exists:publisher,kode_publisher',
            'type' => 'required|in:ebook,hardcopy',
            'harga' => 'required|numeric',
            'stock' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $validated;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('books', 'public');
        }

        if ($id) {
            $book = Books::findOrFail($id);
            $book->update($data);
            return redirect()->route('Books.index')->with('success', 'Buku berhasil diperbarui!');
        } else {
            Books::create($data);
            return redirect()->route('Books.index')->with('success', 'Buku berhasil ditambahkan!');
        }
    }

    public function delete($id)
    {
        $book = Books::findOrFail($id);
        if ($book->photo) {
            \Storage::disk('public')->delete($book->photo);
        }
        $book->delete();

        return redirect()->route('Books.index')->with('success', 'Buku berhasil dihapus!');
    }

    public function invoice()
    {
        // logika invoice
    }
}

