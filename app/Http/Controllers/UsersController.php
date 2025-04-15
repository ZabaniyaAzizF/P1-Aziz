<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Store or Update a user
     */
    public function store(Request $request)
    {

        // dd($request->all());
        // Validasi input dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telepon' => 'nullable|string|max:13',
            'alamat' => 'nullable|string|max:80',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Admin,Pengguna,Supervisor,Petugas',
        ]);

        if ($request->id) {
            // Update user berdasarkan user_id
            $user = User::findOrFail($request->id);
            $user->update($validated);

            // Jika password diisi, perbarui passwordnya
            if ($request->filled('password')) {
                $user->update(['password' => bcrypt($request->password)]);
            }

            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
        } else {
            // Menambahkan user baru
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            }

            User::create($validated);
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
        }
    }

    /**
     * Get data for editing
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Display the invoice page for users
     */
    public function invoice(Request $request)
    {
        $users = User::all();
        return view('users.invoice', compact('users'));
    }
}
