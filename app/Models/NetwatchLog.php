<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetwatchLog extends Model
{
    use HasFactory;

    protected $fillable = ['status','host','time','date'];
    const CREATED_AT = null; // Nama kolom created_at
    const UPDATED_AT = null; // Nonaktifkan kolom updated_at
}
