<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $primaryKey = 'kode_promo';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'kode_promo',
        'nama',
        'type',
        'discount',
        'start_date',
        'end_date',
        'ref_id',
    ];

    // Relasi ke kategori
    public function kategori() {
        return $this->belongsTo(Kategori::class, 'ref_id', 'kode_kategori');
    }

    // Relasi ke author
    public function author() {
        return $this->belongsTo(Author::class, 'ref_id', 'kode_author');
    }

    // Relasi ke publisher
    public function publisher() {
        return $this->belongsTo(Publisher::class, 'ref_id', 'kode_publisher');
    }

    // Relasi ke member
    public function member() {
        return $this->belongsTo(User::class, 'ref_id', 'id');
    }

    // Scope untuk promo aktif
    public function scopeAktif($query)
    {
        $today = now()->toDateString();
        return $query->where('start_date', '<=', $today)
                     ->where('end_date', '>=', $today);
    }
}
