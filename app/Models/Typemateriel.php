<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Typemateriel extends Model
{
    use HasFactory;

    public function materiels(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
