<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';
    
    protected $primaryKey = 'kode_pengaduan';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_pengaduan',
        'nama_pengadu',
        'kode_meja',
        'keterangan',
        'photo_barang',
        'status',
    ];

     // Relasi ke Meja (Barang belongsTo Meja)
     public function meja()
     {
         return $this->belongsTo(Meja::class, 'kode_meja', 'kode_meja');
     }
}
