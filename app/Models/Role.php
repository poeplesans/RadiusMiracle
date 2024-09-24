<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function userrole()
    {
        return $this->hasMany(User::class, 'role', 'id');
        // 'role' adalah kolom di tabel users
        // 'name' adalah kolom di tabel roles
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // public function subMenus()
    // {
    //     return $this->belongsToMany(SubMenu::class, 'role_sub_menu');
    // }

    public function roleSubMenus()
    {
        return $this->hasMany(RoleSubMenu::class, 'role_id');
    }

    // Tambahkan relasi ke sub_menus melalui roleSubMenus
    public function subMenus()
    {
        return $this->belongsToMany(SubMenu::class, 'role_sub_menu', 'role_id', 'sub_menu_id');
    }
}
