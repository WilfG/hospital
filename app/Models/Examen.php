<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examen extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }
}
