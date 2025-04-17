<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    
    protected $primaryKey = 'kode_kategori';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
    ];

}
