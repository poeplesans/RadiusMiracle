<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleSubMenu extends Model
{
    // Definisikan nama tabel secara eksplisit jika tidak mengikuti konvensi Laravel
    protected $table = 'role_sub_menu';

    // Nonaktifkan timestamps jika tidak ada kolom created_at atau updated_at di tabel
    public $timestamps = true;

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = ['role_id', 'sub_menu_id'];

    // Definisikan relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    // Definisikan relasi ke SubMenu
    public function subMenu()
    {
        return $this->belongsTo(SubMenu::class, 'sub_menu_id');
    }
}
