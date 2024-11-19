<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Magasin extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function drug() :BelongsTo
    {
        return $this->belongsTo(Drug::class);
    }
    public function material() :BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
