<?php

use Illuminate\Support\Facades\DB;

function autonumber($tabel, $kolom, $lebar = 3, $awalan = '')
{
    // Ambil data terakhir berdasarkan kolom yang ditentukan
    $latestRecord = DB::table($tabel)->orderBy($kolom, 'desc')->first();

    if (!$latestRecord) {
        $nomor = 1; // Jika tidak ada data, mulai dari 1
    } else {
        // Ambil angka dari kode terakhir (misal: KTG001 → 001 → 1)
        $nomor = (int) substr($latestRecord->$kolom, strlen($awalan)) + 1;
    }

    // Format menjadi KTGxxx, MJAxxx, BRGxxx, dll.
    return $awalan . str_pad($nomor, $lebar, "0", STR_PAD_LEFT);
}
