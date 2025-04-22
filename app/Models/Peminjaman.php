<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'kode_peminjaman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'kode_books',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Book
    public function buku()
    {
        return $this->belongsTo(Books::class, 'kode_books', 'kode_books');
    }
}
