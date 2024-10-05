<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['full_name','username','nip','telegram_id','username', 'email', 'password', 'user_type','office_id','role','status'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    public function role_id()
    {
        return $this->belongsTo(Role::class, 'role');
    }
}