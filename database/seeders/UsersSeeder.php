<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'telepon' => '081234567890',
                'alamat' => 'Jl. Contoh Alamat No. 1',
                'role' => 'Admin',
                'saldo' => 0,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Petugas',
                'email' => 'petugas@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'telepon' => '081234567891',
                'alamat' => 'Jl. Contoh Alamat No. 4',
                'role' => 'Petugas',
                'saldo' => 0,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supervisor',
                'email' => 'supervisor@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'telepon' => '081234567891',
                'alamat' => 'Jl. Contoh Alamat No. 4',
                'role' => 'Supervisor',
                'saldo' => 0,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Member',
                'email' => 'member@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'telepon' => '081234567891',
                'alamat' => 'Jl. Contoh Alamat No. 4',
                'role' => 'Member',
                'saldo' => 100000, // 👈 saldo wajib dicantumkan kalau mau diisi
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
