<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ExpenseRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function expense():HasOne
    {
        return $this->hasOne(Expense::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
