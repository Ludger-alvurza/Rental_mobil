<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratS extends Model
{
    use HasFactory;
    protected $table = 'syarat_sewa';
    protected $fillable = ['keterangan'];
}
