<?php

namespace App\Http\Controllers;

use App\Models\Books_fisik;
use App\Models\Kategori;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function indexMember()
    {
        $userId = auth()->id();
    
        $books = Books_fisik::all();
        $kategoriList = Kategori::all();
        $authors = Author::all();
        $publisherList = Publisher::all();
    
        $userPembayaran = DB::table('peminjaman')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->pluck('kode_books_fisik')
            ->toArray();    
        
        return view('books_fisik.member', compact('books', 'kategoriList', 'authors', 'publisherList', 'userPembayaran'));
    }    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'kode_kategori' => 'required|string|max:6',
            'kode_author' => 'required|string|max:6',
            'kode_publisher' => 'required|string|max:6',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'isbn' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
        ]);
    
        // Generate kode otomatis
        $validated['kode_books_fisik'] = autonumber('books_fisik', 'kode_books_fisik', 5, 'BKF');
    
        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/uploads/books/photo'), $photoName);
            $validated['photo'] = $photoName;
        }
    
        Books_fisik::create($validated);
    
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
            'deskripsi' => 'nullable|string',
            'isbn' => 'nullable|string|max:20',
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
    
        // Jika ada upload foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($book->photo) {
                Storage::disk('public')->delete($book->photo);
            }
    
            $data['photo'] = $request->file('photo')->store('covers', 'public');
        }
    
        $book->update($data);
    
        return redirect()->route('Books_fisik.index')->with('success', 'Buku berhasil diperbarui.');
    }    

    public function delete($kode_books_fisik)
    {
        $book = Books_fisik::findOrFail($kode_books_fisik);

        if ($book->photo) {
            Storage::disk('public')->delete($book->photo);
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
