<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageRating extends Model
{
    use HasFactory;

    protected $table = 'message_rating'; // Nama tabel yang dipakai

    protected $fillable = [
        'id',
        'message',
        'id_mobil',
        'rating'
    ];

    /**
     * Relationship to User
     */
    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }
    public function mobil()
{
    return $this->belongsTo(Mobil::class, 'id_mobil');
}

}
