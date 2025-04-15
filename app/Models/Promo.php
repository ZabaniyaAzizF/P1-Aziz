<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    
    protected $primaryKey = 'kode_promo';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_promo',
        'type',
        'discount',
        'start_date',
        'end_date',
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
