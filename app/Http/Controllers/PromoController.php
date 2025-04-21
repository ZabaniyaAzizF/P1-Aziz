<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Kategori;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\User;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    /**
     * Display a listing of the promo.
     */
    public function index()
    {
        $promos = Promo::with(['kategori', 'author', 'publisher', 'member'])->get();
        $kategori = Kategori::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $members = User::where('role', 'Member')->get();
    
        return view('promo.index', compact('promos', 'kategori', 'authors', 'publishers', 'members'));
    }
    

    /**
     * Store or Update a promo
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_promo' => 'required',
            'nama' => 'required|string',
            'type' => 'required|in:kategori,author,publisher,member',
            'ref_id' => 'required',
            'discount' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Menyimpan atau memperbarui promo
        Promo::updateOrCreate(
            ['kode_promo' => $request->kode_promo],
            [
                'nama' => $request->nama,
                'type' => $request->type,
                'ref_id' => $request->ref_id,
                'discount' => $request->discount,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]
        );

        // Setelah promo disimpan, kita update harga buku yang terkait
        $this->applyPromoToBooks($request->kode_promo);

        return redirect()->route('Promo.index')->with('success', 'Promo berhasil disimpan.');
    }

    // Fungsi untuk menerapkan promo pada buku yang terkait
    private function applyPromoToBooks($kode_promo)
    {
        $promo = Promo::where('kode_promo', $kode_promo)->first();
    
        if ($promo) {
            $books = Books::where('kode_kategori', $promo->ref_id)
                ->orWhere('kode_author', $promo->ref_id)
                ->orWhere('kode_publisher', $promo->ref_id)
                ->get();
    
            foreach ($books as $book) {
                // Hanya simpan harga asli jika belum pernah disimpan
                if ($book->harga_asli === null) {
                    $book->harga_asli = $book->harga;
                }
    
                $book->harga = $book->harga_asli - ($book->harga_asli * ($promo->discount / 100));
                $book->save();
            }
        }
    }      
    
    // Fungsi untuk mendapatkan tabel berdasarkan tipe promo
    protected function getTableForType($type)
    {
        switch ($type) {
            case 'kategori':
                return 'kategori'; // Tabel kategori
            case 'author':
                return 'author'; // Tabel authors
            case 'publisher':
                return 'publisher'; // Tabel publishers
            case 'member':
                return 'users'; // Tabel users (role 'Member')
            default:
                return '';
        }
    }    

    // Fungsi untuk mendapatkan kolom berdasarkan tipe promo
    protected function getColumnForType($type)
    {
        switch ($type) {
            case 'kategori':
                return 'kode_kategori'; // Kolom untuk kategori
            case 'author':
                return 'kode_author'; // Kolom untuk authors
            case 'publisher':
                return 'kode_publisher'; // Kolom untuk publishers
            case 'member':
                return 'id'; // Kolom untuk users (role 'Member')
            default:
                return '';
        }
    }

    /**
     * Get data for editing (optional: API or modal-based)
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return response()->json($promo);
    }

    // Menampilkan promo untuk member saja
    public function memberPromo()
    {
        // Filter promo dengan tipe 'member'
        $promos = Promo::where('type', 'member')->get();
        $kategori = Kategori::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $members = User::where('role', 'Member')->get();
        
        return view('promo.index', compact('promos', 'kategori', 'authors', 'publishers', 'members'));
    }

    // Fungsi untuk menghapus promo berdasarkan route model binding
    public function delete(Promo $kode_promo)
    {
        // Ambil semua buku yang terpengaruh promo
        $books = Books::where('kode_kategori', $kode_promo->ref_id)
            ->orWhere('kode_author', $kode_promo->ref_id)
            ->orWhere('kode_publisher', $kode_promo->ref_id)
            ->get();
    
        foreach ($books as $book) {
            if ($book->harga_asli !== null) {
                $book->harga = $book->harga_asli;   // Kembalikan harga
                $book->harga_asli = null;           // Kosongkan kembali
                $book->save();
            }
        }
    
        $kode_promo->delete();
    
        return redirect()->route('Promo.index')->with('success', 'Promo berhasil dihapus.');
    }    

    /**
     * Optional: generate invoice or apply promo on checkout
     */
    public function invoice(Request $request)
    {
        $promo = Promo::where('kode_promo', $request->kode_promo)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($promo) {
            return response()->json([
                'success' => true,
                'discount' => $promo->discount,
                'message' => 'Promo tersedia dan valid.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Promo tidak tersedia atau sudah tidak berlaku.',
            ]);
        }
    }
}
