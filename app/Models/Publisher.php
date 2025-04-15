<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $table = 'publisher';
    
    protected $primaryKey = 'kode_publisher';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_publisher',
        'nama_publisher',
    ];

    
    // // Relasi ke Model Barang
    // public function barang()
    // {
    //     return $this->hasMany(Barang::class, 'kode_kategori', 'kode_kategori');
    // }

    // public function subKategori()
    // {
    //     return $this->belongsTo(SubKategori::class, 'kode_sub', 'kode_sub');
    // }

}
