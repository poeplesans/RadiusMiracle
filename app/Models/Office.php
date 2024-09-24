<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    // Tentukan nama tabel secara eksplisit
    protected $table = 'office';
    protected $fillable = ['office_name', 'desc', 'db_name_users', 'status','password','username','port','host'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
