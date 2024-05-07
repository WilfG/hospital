<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultation extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    // public function examens(): HasMany
    // {
    //     return $this->hasMany(Examen::class);
    // }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

}
