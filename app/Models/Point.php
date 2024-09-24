<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = ['line_id','map_id', 'latitude', 'longitude','village','county','state','region','display_name'];

    // public function line()
    // {
    //     return $this->belongsTo(Line::class);
    // }
}
