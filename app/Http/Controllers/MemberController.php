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
        $member = User::where('role', 'member')->get();
        return view('member.index', compact('member'));
    }

    /**
     * Store or Update a member
     */
    public function store(Request $request)
    {
        $isUpdate = $request->id ? true : false;
    
        $rules = [
            'name' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:13',
            'alamat' => 'nullable|string|max:80',
        ];
    
        if ($isUpdate) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $request->id;
            $rules['password'] = 'nullable|string|min:8';
        } else {
            $rules['email'] = 'required|email|max:255|unique:users';
            $rules['password'] = 'required|string|min:8';
        }
    
        $validated = $request->validate($rules);
        $validated['role'] = 'Member';
    
        if ($isUpdate) {
            $user = User::findOrFail($request->id);
    
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            } else {
                unset($validated['password']);
            }
    
            $user->update($validated);
            return redirect()->route('Member.index')->with('success', 'Member berhasil diperbarui!');
        } else {
            $validated['password'] = bcrypt($request->password);
            User::create($validated);
            return redirect()->route('Member.index')->with('success', 'Member berhasil ditambahkan!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $member = User::findOrFail($id);
        $member->delete();
        return redirect()->route('Member.index')->with('success', 'member berhasil dihapus.');
    }

    public function invoice(Request $request)
    {
        $member = User::where('role', 'member')->get();
        return view('member.invoice', compact('member'));
    }
}
