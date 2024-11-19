<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function typemateriel(): BelongsTo
    {
        return $this->belongsTo(Typemateriel::class);

    }
}
