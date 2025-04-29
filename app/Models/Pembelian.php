<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'kode_pembelian';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_pembelian',
        'user_id',
        'kode_books_digital',
        'tanggal_beli',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Book
    public function buku_digital()
    {
        return $this->belongsTo(Books_digital::class, 'kode_books_digital', 'kode_books_digital');
    }
}
