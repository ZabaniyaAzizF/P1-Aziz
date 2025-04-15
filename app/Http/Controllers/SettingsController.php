<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $setting = Settings::get()->first();
        return view('setting.index',
        ['setting' => $setting]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'path_logo' => 'nullable|file|image|max:2048', // Validasi untuk gambar
            'nama' => 'required|max:100',
            'email' => 'required|email|max:50',
            'telepon' => 'required|max:20',
            'alamat' => 'required',
        ]);

        $setting = Settings::find($id);
        if ($setting) {
            // Proses upload file logo
            if ($request->hasFile('path_logo')) {
                // Hapus file lama jika ada
                if ($setting->path_logo && file_exists(storage_path('app/public/' . $setting->path_logo))) {
                    unlink(storage_path('app/public/' . $setting->path_logo));
                }

                // Simpan file baru
                $path = $request->file('path_logo')->store('logos', 'public');
                $setting->path_logo = $path;
            }

            // Update data lainnyxa
            $setting->nama = $request->input('nama');
            $setting->email = $request->input('email');
            $setting->telepon = $request->input('telepon');
            $setting->alamat = $request->input('alamat');
            $setting->save();

            return redirect()->route('Settings')->with('success', 'Settings updated successfully.');
        }

        return redirect()->route('Settings')->with('error', 'Settings not found.');
    }
    
}
