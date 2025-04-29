<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books_fisik extends Model
{
    use HasFactory;

    protected $table = 'books_fisik';

    protected $primaryKey = 'kode_books_fisik';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kode_books_fisik',
        'title',
        'kode_kategori',
        'kode_publisher',
        'kode_author',
        'deskripsi',
        'isbn',
        'photo',
        'harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kode_kategori', 'kode_kategori');
    }
    
    public function author()
    {
        return $this->belongsTo(Author::class, 'kode_author', 'kode_author');
    }
    
    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'kode_publisher', 'kode_publisher');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'kode_books_fisik', 'kode_books_fisik');
    }
    
}
