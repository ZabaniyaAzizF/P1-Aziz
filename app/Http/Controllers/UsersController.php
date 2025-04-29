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

    public function indexAdmin(Request $request)
    {
        $users = User::where('role', 'Admin')->get();
        return view('users.admin', compact('users'));
    }    

    public function indexSupervisor(Request $request)
    {
        $users = User::where('role', 'Supervisor')->get();
        return view('users.supervisor', compact('users'));
    }    

    public function indexPetugas(Request $request)
    {
        $users = User::where('role', 'Petugas')->get();
        return view('users.petugas', compact('users'));
    }    

    /**
     * Store or Update a user
     */
    public function store(Request $request)
    {
        $isUpdate = $request->id ? true : false;
    
        $rules = [
            'name' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:13',
            'alamat' => 'nullable|string|max:80',
            'role' => 'required|in:Admin,Pengguna,Supervisor,Petugas,Member',
        ];
    
        // Validasi email berbeda antara create dan update
        if ($isUpdate) {
            $rules['email'] = 'required|email|max:255|unique:users,email,' . $request->id;
            $rules['password'] = 'nullable|string|min:8';
        } else {
            $rules['email'] = 'required|email|max:255|unique:users';
            $rules['password'] = 'required|string|min:8';
        }
    
        $validated = $request->validate($rules);
    
        if ($isUpdate) {
            $user = User::findOrFail($request->id);
    
            // Jika password dikosongkan, jangan diubah
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            } else {
                unset($validated['password']);
            }
    
            $user->update($validated);
            return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
        } else {
            $validated['password'] = bcrypt($request->password);
            User::create($validated);
            return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
        }
    }    

    public function storeAdmin(Request $request)
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
        $validated['role'] = 'Admin';
    
        if ($isUpdate) {
            $user = User::findOrFail($request->id);
    
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            } else {
                unset($validated['password']);
            }
    
            $user->update($validated);
            return redirect()->route('users.admin.index')->with('success', 'Admin berhasil diperbarui!');
        } else {
            $validated['password'] = bcrypt($request->password);
            User::create($validated);
            return redirect()->route('users.admin.index')->with('success', 'Admin berhasil ditambahkan!');
        }
    }    

    public function storeSupervisor(Request $request)
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
        $validated['role'] = 'Supervisor';
    
        if ($isUpdate) {
            $user = User::findOrFail($request->id);
    
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            } else {
                unset($validated['password']);
            }
    
            $user->update($validated);
            return redirect()->route('users.supervisor.index')->with('success', 'Supervisor berhasil diperbarui!');
        } else {
            $validated['password'] = bcrypt($request->password);
            User::create($validated);
            return redirect()->route('users.supervisor.index')->with('success', 'Supervisor berhasil ditambahkan!');
        }
    }    

    public function storePetugas(Request $request)
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
        $validated['role'] = 'Petugas';
    
        if ($isUpdate) {
            $user = User::findOrFail($request->id);
    
            if ($request->filled('password')) {
                $validated['password'] = bcrypt($request->password);
            } else {
                unset($validated['password']);
            }
    
            $user->update($validated);
            return redirect()->route('users.petugas.index')->with('success', 'Petugas berhasil diperbarui!');
        } else {
            $validated['password'] = bcrypt($request->password);
            User::create($validated);
            return redirect()->route('users.petugas.index')->with('success', 'Petugas berhasil ditambahkan!');
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

    public function deleteAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.admin.index')->with('success', 'User berhasil dihapus!');
    }

    public function deleteSupervisor($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.supervisor.index')->with('success', 'User berhasil dihapus!');
    }

    public function deletePetugas($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.petugas.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Display the invoice page for users
     */
    public function invoice(Request $request)
    {
        $users = User::all();
        return view('users.invoice', compact('users'));
    }

    public function invoiceAdmin(Request $request)
    {
        $users = User::where('role', 'Admin')->get();
        return view('users.invoice_admin', compact('users'));
    }

    public function invoiceSupervisor(Request $request)
    {
        $users = User::where('role', 'Supervisor')->get();
        return view('users.invoice_supervisor', compact('users'));
    }

    public function invoicePetugas(Request $request)
    {
        $users = User::where('role', 'Petugas')->get();
        return view('users.invoice_petugas', compact('users'));
    }
}
