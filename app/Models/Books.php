<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $primaryKey = 'kode_books';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_books',
        'title',
        'kode_kategori',
        'kode_publisher',
        'kode_author',
        'file_url',
        'file_book',
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
    
}
