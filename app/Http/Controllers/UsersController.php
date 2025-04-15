<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        return view('users.index', ['users' => $users]);
    }

    public function invoice(Request $request)
    {
        $users = User::all();

        return view('users.invoice', ['users' => $users]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'telepon' => 'nullable|string|max:13',
            'alamat' => 'nullable|string|max:80',
            'status' => 'required|in:aktif,tidak aktif',
            'role' => 'required|in:admin,pengguna,supervisor,petugas',
        ]);

        $validated['password'] = bcrypt($validated['password']); // Hash password

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(Request $request, $id)
    {
        $data = User::find($id);

        return view('users.update', compact('data'));
    }

    public function update(Request $request, string $id)
    {
        $data = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'telepon' => 'nullable|string|max:13',
            'alamat' => 'nullable|string|max:80',
            'status' => 'required|in:aktif,tidak aktif',
            'role' => 'required|in:admin,pengguna,supervisor,petugas', // Validasi untuk role
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']); // Hash password
        } else {
            unset($validated['password']); // Ignore if password is not updated
        }

        $data->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function delete(Request $request, $id)
    {
        $data = User::findOrFail($id);

        if ($data) {
            $data->delete();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
        }

        return redirect()->route('users.index')->with('error', 'User tidak ditemukan!');
    }
}
