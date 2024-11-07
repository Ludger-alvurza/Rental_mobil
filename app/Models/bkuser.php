<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bkuser extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = ['id_user','name','no_plat','name_mobil','lama_sewa','keterangan','user_id','id_mobil','status_payment','status_booking','booking_start','booking_end','status','pembatalan','id'];
    public function user()
    {
        return $this->belongsTo(User::class,'id_user');
    }
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'id_mobil');
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transactions');
    }
    public function denda()
    {
        return $this->hasMany(ItemTransaction::class, 'id_booking');
    }




}
