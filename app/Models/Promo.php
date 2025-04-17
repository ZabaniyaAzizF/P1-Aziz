<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';
    
    protected $primaryKey = 'kode_promo';
    protected $keyType = 'string'; // Tipe data primary key adalah string
    public $incrementing = false;
    protected $fillable = [
        'kode_promo',
        'type',
        'discount',
        'start_date',
        'end_date',
    ];

    public function Books() {
        return $this->belongsToMany(Book::class, 'promo_books', 'kode_promo', 'kode_buku');
    }
    
    public function Kategori() {
        return $this->belongsToMany(Kategori::class, 'promo_kategori', 'kode_promo', 'kode_kategori');
    }
    
    public function Publisher() {
        return $this->belongsToMany(Publisher::class, 'promo_publisher', 'kode_promo', 'kode_publisher');
    }
    
    public function Author() {
        return $this->belongsToMany(Author::class, 'promo_author', 'kode_promo', 'kode_author');
    }
    
    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

}
