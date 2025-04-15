<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'meja';
    
    protected $primaryKey = 'kode_meja';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kode_meja',
        'nama_meja',
        'kode_barang',
    ];

    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'meja_barang', 'kode_meja', 'kode_barang');
    }


    // Relasi ke Ruangan (Meja belongsTo Ruangan)
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'kode_ruangan', 'kode_ruangan');
    }

}
