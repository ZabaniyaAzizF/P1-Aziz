<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $member = User::all();
        return view('member.index', compact('member'));
    }

    /**
     * Store or Update a member
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_member' => 'required|string|max:255',
        ]);

        if ($request->member_id) {
            // UPDATE member berdasarkan ID
            $member = User::findOrFail($request->member_id);
            $member->update([
                'nama_member' => $validated['nama_member'],
            ]);

            return redirect()->route('member.index')->with('success', 'member berhasil diperbarui.');
        } else {
            // Gunakan autonumber untuk kode_member
            $validated['kode_member'] = autonumber('member', 'kode_member', 3, 'KTG');

            // INSERT member baru
            User::create($validated);
            return redirect()->route('member.index')->with('success', 'member berhasil ditambahkan.');
        }
    }

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $member = User::findOrFail($id);
        return response()->json($member);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $member = User::findOrFail($id);
        $member->delete();
        return redirect()->route('member.index')->with('success', 'member berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $member = User::all();
        return view('member.invoice', compact('member'));
    }
}
