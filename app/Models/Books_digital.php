<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books_digital extends Model
{
    use HasFactory;

    protected $table = 'books_digital';

    protected $primaryKey = 'kode_books_digital';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'kode_books_digital',
        'title',
        'kode_kategori',
        'kode_publisher',
        'kode_author',
        'file_book',
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

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'kode_books_digital', 'kode_books_digital');
    }
}
