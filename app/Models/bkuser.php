<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bkuser extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = ['id_user','name','no_plat','name_mobil','lama_sewa','keterangan','user_id','id_mobil'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil');
    }


}
