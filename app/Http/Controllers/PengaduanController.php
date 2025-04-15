<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengaduan = Pengaduan::with(['meja.ruangan'])->get();
        return view('pengaduan.index', compact('pengaduan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $meja = Meja::all();
        return view('pengaduan.create', compact('meja'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_meja' => 'required',
            'keterangan' => 'required',
            'photo_barang' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('photo_barang')->store('pengaduan', 'public');

        Pengaduan::create([
            'kode_pengaduan' => $request->kode_pengaduan,
            'nama_pengadu' => Auth::user()->name,
            'kode_meja' => $request->kode_meja,
            'keterangan' => $request->keterangan,
            'photo_barang' => $imagePath,
            'status' => 'Pending',
        ]);

        return redirect()->route('Pengaduan.index')->with('success', 'Pengaduan berhasil diajukan!');
    }

    /**
     * Approve the specified Pengaduan.
     */
    public function approve($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'Disetujui']);
        return back()->with('success', 'Pengaduan disetujui!');
    }

    /**
     * Reject the specified Pengaduan.
     */
    public function reject($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'Ditolak']);
        return back()->with('error', 'Pengaduan ditolak!');
    }

    /**
     * Generate invoice for Pengaduan.
     */
    public function invoice()
    {
        $pengaduan = Pengaduan::where('status', 'Disetujui')->get();
        return view('pengaduan.invoice', compact('pengaduan'));
    }
}
