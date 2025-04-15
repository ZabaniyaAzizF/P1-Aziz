<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    
    protected $primaryKey = 'kode_pengajuan';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_pengajuan',
        'nama_pengaju',
        'nama_barang',
        'kode_meja',
        'status',
    ];

     // Relasi ke Meja (Barang belongsTo Meja)
     public function meja()
     {
         return $this->belongsTo(Meja::class, 'kode_meja', 'kode_meja');
     }
}
