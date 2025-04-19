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
        $kategori = Kategori::all();
        $authors = Author::all();
        $publishers = Publisher::all();

        return view('books.index', compact('books', 'kategori', 'publishers', 'authors'));
    }

    public function indexMember(Request $request)
    {
        // Membuat query untuk Books dengan relasi kategori, author, dan publisher
        $query = Books::with(['kategori', 'author', 'publisher']);
    
        // Filter berdasarkan kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('kode_kategori', $request->category);
        }
    
        // Filter berdasarkan pengarang
        if ($request->has('author') && $request->author != '') {
            $query->where('kode_author', $request->author);
        }
    
        // Filter berdasarkan penerbit
        if ($request->has('publisher') && $request->publisher != '') {
            $query->where('kode_publisher', $request->publisher);
        }
    
        // Mengambil data buku yang sudah difilter
        $books = $query->get();
    
        // Mengambil data kategori, author, dan publisher untuk dropdown filter
        $kategoriList = Kategori::all();
        $authorList = Author::all();
        $publisherList = Publisher::all();
    
        // Menampilkan view dengan data buku dan daftar kategori, author, dan publisher
        return view('books.member', compact('books', 'kategoriList', 'authorList', 'publisherList'));
    }    

    public function storeBooks(Request $request)
    {
        $validated = $request->validate([
            'kode_books'     => 'nullable|string|max:8',
            'title'          => 'required|string|max:255',
            'kode_kategori'  => 'required|string|max:6',
            'kode_author'    => 'required|string|max:6',
            'kode_publisher' => 'required|string|max:6',
            'harga'          => 'required|numeric',
            'photo'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_book'      => 'nullable|mimes:pdf',
            'file_url'       => 'nullable|url',
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

        if ($request->kode_books && Books::find($request->kode_books)) {
            // UPDATE
            $book = Books::findOrFail($request->kode_books);
            $book->update($validated);
            return redirect()->route('Books.index')->with('success', 'Buku berhasil diperbarui.');
        } else {
            // INSERT
            $validated['kode_books'] = autonumber('books', 'kode_books', 5, 'BOK');
            Books::create($validated);
            return redirect()->route('Books.index')->with('success', 'Buku berhasil ditambahkan.');
        }
    }

    public function update(Request $request, $kode_books)
    {
        // Validasi data yang diterima dari form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'kode_kategori' => 'required|string',
            'kode_author' => 'required|string',
            'kode_publisher' => 'required|string',
            'harga' => 'required|numeric',
            'file_url' => 'nullable|url',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file_book' => 'nullable|file',
        ]);

        // Cari buku berdasarkan kode_books
        $book = Books::where('kode_books', $kode_books)->first();

        // Jika buku tidak ditemukan
        if (!$book) {
            return redirect()->route('Books.index')->with('error', 'Buku tidak ditemukan.');
        }

        // Update data buku
        $book->title = $validatedData['title'];
        $book->kode_kategori = $validatedData['kode_kategori'];
        $book->kode_author = $validatedData['kode_author'];
        $book->kode_publisher = $validatedData['kode_publisher'];
        $book->harga = $validatedData['harga'];
        $book->file_url = $validatedData['file_url'] ?? $book->file_url;

        // Menangani upload file buku
        if ($request->hasFile('file_book')) {
            $book->file_url = $request->file('file_book')->store('books', 'public');
        }

        // Menangani upload photo cover
        if ($request->hasFile('photo')) {
            $book->photo = $request->file('photo')->store('photos', 'public');
        }

        // Simpan perubahan ke database
        $book->save();

        // Redirect kembali ke daftar buku dengan pesan sukses
        return redirect()->route('Books.index')->with('success', 'Buku berhasil diperbarui.');
    }


    public function delete($id)
    {
        $book = Books::findOrFail($id);

        // Hapus file fisik jika ada
        if ($book->photo && file_exists(public_path('uploads/books/photo/' . $book->photo))) {
            unlink(public_path('uploads/books/photo/' . $book->photo));
        }

        if ($book->file_book && file_exists(public_path('uploads/books/pdf/' . $book->file_book))) {
            unlink(public_path('uploads/books/pdf/' . $book->file_book));
        }

        $book->delete();
        return redirect()->route('Books.index')->with('success', 'Buku berhasil dihapus.');
    }

    public function invoice()
    {
        $books = Books::all();
        return view('books.invoice', compact('books'));
    }
}
