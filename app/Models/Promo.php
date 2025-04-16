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
    
    public function member()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    

}
