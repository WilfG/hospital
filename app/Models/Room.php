<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function beds(){
        return $this->hasMany(Bed::class);
    }

    public function admission(){
        return $this->belongsTo(Admission::class);
    }
}
