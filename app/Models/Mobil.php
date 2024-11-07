<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;
    protected $table = 'mobils';
    protected $fillable = ['gambar','name','type','brand','year','price_per_day','availability','denda','no_plat'];

    public function booking()
{
    return $this->hasMany(bkuser::class, 'id_mobil');
}
}
