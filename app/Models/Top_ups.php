<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Top_ups extends Model
{
    use HasFactory;

    protected $table = 'top_ups';
    protected $primaryKey = 'kode_topups';
    public $incrementing = false; 
    protected $keyType = 'string';

    public $timestamps = false; 

    protected $fillable = [
        'kode_topups',
        'user_id',
        'amount',
        'method',
        'status',
        'created_at',
        'bukti_transfer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
