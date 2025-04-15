<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $primaryKey = 'kode_barang';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kode_kategori',
        'kode_ruangan',
        'kode_merk',
        'kondisi',
        'deskripsi',
        'photo_barang',
        'status',
    ];

    // Relasi ke Kategori (Barang belongsTo Kategori)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kode_kategori', 'kode_kategori');
    }

    // Relasi ke Kategori (Barang belongsTo Kategori)
    public function merk()
    {
        return $this->belongsTo(Merk::class, 'kode_merk', 'kode_merk');
    }

    public function meja()
    {
        return $this->belongsToMany(Meja::class, 'meja_barang', 'kode_barang', 'kode_meja');
    }

     // Relasi ke Ruangan (Barang belongsTo Meja)
     public function ruangan()
     {
         return $this->belongsTo(Ruangan::class, 'kode_ruangan', 'kode_ruangan');
     }
}
