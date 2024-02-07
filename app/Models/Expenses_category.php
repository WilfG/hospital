<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expenses_category extends Model
{
    use HasFactory;

    protected $guarded = []; 
    
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
