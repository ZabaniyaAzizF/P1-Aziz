<?php

namespace App\Http\Controllers;

use App\Models\Top_ups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TopupController extends Controller
{
    public function index()
    {
        $topups = Top_ups::with('user')->get(); // Mengambil semua data top up
        $kodetopup = autonumber('top_ups', 'kode_topups', 3, 'TUP'); // Generate kode top-up baru
        return view('topup.index', compact('topups', 'kodetopup'));
    }

    public function indexMember()
    {
        $userId = auth()->id(); // ambil ID user yang login
        $topups = Top_ups::where('user_id', $userId)->get();
        $kodetopup = autonumber('top_ups', 'kode_topups', 3, 'TUP'); // Generate kode top-up baru
    
        return view('topup.member', compact('topups', 'kodetopup'));
    }
    
    

    // Method untuk menyimpan data top-up baru
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'method' => 'required',
            'photo' => 'nullable|image|max:2048', // Validasi file upload
        ]);

        // Menyimpan file bukti transfer jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('topups', 'public');
        }

        // Menyimpan data top up baru
        Top_ups::create([
            'kode_topups' => $request->kode_topups,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'method' => $request->method,
            'bukti_transfer' => $photoPath,
        ]);

        return redirect()->route('Topup.member.index')->with('success', 'Top up berhasil disimpan.');
    }

    public function updateStatus(Request $request, $kode_topups)
    {
        // Validasi status yang dipilih
        $request->validate([
            'status' => 'required|in:pending,success,failed',
        ]);

        // Cari top-up berdasarkan kode
        $topup = Top_ups::where('kode_topups', $kode_topups)->firstOrFail();

        // Update status
        $topup->status = $request->status;

        // Jika status berhasil, tambahkan saldo pada user terkait
        if ($topup->status == 'success') {
            // Cari user berdasarkan user_id
            $user = $topup->user;  // assuming that `user()` is a valid relationship method

            // Tambahkan jumlah top-up ke saldo user
            $user->saldo += $topup->amount;
            $user->save();
        }

        // Simpan perubahan status
        $topup->save();

        return redirect()->back()->with('success', 'Status top-up berhasil diperbarui!');
    }

    // Fungsi untuk invoice
    public function generateInvoice()
    {
        // Implementasi logika invoice (misalnya menggunakan PDF atau template HTML)
    }
}