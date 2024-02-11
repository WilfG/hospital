<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = [];

   
    public function expenses_category(){
        return $this->belongsTo(Expenses_category::class);
    }

    public function expenseRequest()
    {
        return $this->belongsTo(ExpenseRequest::class);
    }


}
