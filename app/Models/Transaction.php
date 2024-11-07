<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'transactions';
    protected $fillable = ['id','id_transaction','total'];

    public function ItemTransaction()
    {
        return $this->hasMany(ItemTransaction::class,'id_transaction','id');
    }
    public static function getLastCode($prefix)
    {
        $lastNumber = Transaction::query()->where('code','like',$prefix.'%')
        ->withTrashed()
        ->get()->count();

        return $prefix . str_pad(($lastNumber + 1),4,'0',STR_PAD_LEFT);
    }
    public function bookings()
    {
        return $this->hasMany(bkuser::class, 'id_transactions');
    }

}
