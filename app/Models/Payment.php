<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function consultaion(){
        return $this->belongsTo(Consultation::class);
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
}
