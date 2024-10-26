<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as  Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasFactory,Notifiable;

    protected $rememberTokenName = 'remember_token';

    protected $appends = ['age'];

    protected $fillable = ['id','name', 'email', 'password','remember_token','jk'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->age;
    }
    public function cartItems(): HasMany
    {
        return $this->hasMany(Bkuser::class);
    }
}
