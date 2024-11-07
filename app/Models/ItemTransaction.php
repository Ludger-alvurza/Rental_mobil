<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemTransaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'denda';
    protected $fillable = ['id','denda3', 'denda2', 'denda1', 'denda', 'id_transaction', 'id_mobil', 'price', 'qty', 'total','id_booking'];

    public function Transaction(){
        return $this->belongsTo(Transaction::class,'id_transaction','id');
    }

    public function Mobil(){
        return $this->belongsTo(Mobil::class,'id_mobil');
    }
    public function booking()
    {
        return $this->belongsTo(bkuser::class, 'id_booking');
    }

}
