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
                'password' => bcrypt('admin123'),
                'telepon' => '081234567890',
                'alamat' => 'Jl. Contoh Alamat No. 1',
                'role' => 'admin',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Petugas',
                'email' => 'petugas@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('petugas123'),
                'telepon' => '081234567891',
                'alamat' => 'Jl. Contoh Alamat No. 4',
                'role' => 'petugas',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Supervisor',
                'email' => 'supervisor@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('supervisor123'),
                'telepon' => '081234567891',
                'alamat' => 'Jl. Contoh Alamat No. 4',
                'role' => 'supervisor',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru',
                'email' => 'guru@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('guru123'),
                'telepon' => '081234567891',
                'alamat' => 'Jl. Contoh Alamat No. 4',
                'role' => 'guru',
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
