<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    use HasFactory;

    protected $table = 'merk';
    
    protected $primaryKey = 'kode_merk';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_merk',
        'nama_merk',
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'kode_merk', 'kode_merk');
    }

}
