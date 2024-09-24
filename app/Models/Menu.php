<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'header_id','icon'];

    public function header()
    {
        return $this->belongsTo(Header::class);
    }

    public function subMenus()
    {
        return $this->hasMany(SubMenu::class);
    }
}
