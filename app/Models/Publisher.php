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

}
