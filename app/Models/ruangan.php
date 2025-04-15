<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';
    
    protected $primaryKey = 'kode_ruangan';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
    ];

    // Relasi ke Model Barang
    public function barang()
    {
        return $this->hasMany(Barang::class, 'kode_ruangan', 'kode_ruangan');
    }

    // Relasi ke Model Barang
    public function pengajuan()
    {
        return $this->hasMany(Barang::class, 'kode_ruangan', 'kode_ruangan');
    }
}
