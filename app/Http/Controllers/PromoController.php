<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Kategori;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromoController extends Controller
{
    /**
     * Display a listing of the promo.
     */
    public function index()
    {
        $promo = Promo::all();
        $kategoriList = Kategori::all();
        $authorList = Author::all();
        $publisherList = Publisher::all();
        $memberList = User::where('role', 'Member')->get();
    
        return view('promo.index', compact('promo', 'kategoriList', 'authorList', 'publisherList', 'memberList'));
    }

    /**
     * Store or Update a promo
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_promo' => 'required|string|max:6',
            'type' => 'required|string',
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'kode_kategori' => 'nullable|string',
            'kode_author' => 'nullable|string',
            'kode_publisher' => 'nullable|string',
            'user_id' => 'nullable|integer',
        ]);
    
        if ($request->promo_id) {
            $promo = Promo::findOrFail($request->promo_id);
            $promo->update($validated);
            return redirect()->route('Promo.index')->with('success', 'Promo berhasil diperbarui.');
        } else {
            Promo::create($validated);
            return redirect()->route('Promo.index')->with('success', 'Promo berhasil ditambahkan.');
        }
    }
    

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $promo = Promo::findOrFail($id);
        return response()->json($promo);
    }

    /**
     * Remove the specified promo from storage.
     */
    public function delete($id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();
        return redirect()->route('Promo.index')->with('success', 'Promo berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $promo = Promo::all();
        return view('promo.invoice', compact('promo'));
    }
}
