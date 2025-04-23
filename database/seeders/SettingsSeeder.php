<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'path_logo' => 'path/to/logo.png',
                'nama' => 'Nama Perusahaan',
                'email' => 'info@perusahaan.com',
                'telepon' => '081234567890',
                'rekening' => '898778808078',
                'denda' => '10000',
                'alamat' => 'Jl. Contoh Alamat No. 1, Kota, Negara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}