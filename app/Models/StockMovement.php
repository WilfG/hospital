<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'item_type', 'item_id', 'quantity', 'movement_date', 'author', 'purchase_id', 'sale_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
