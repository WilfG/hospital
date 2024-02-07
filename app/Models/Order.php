<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function drugs(): BelongsToMany
    {
        return $this->belongsToMany(Drug::class)->withPivot('quantityOrdered', 'supplierName', 'supplierPhoneNumber');
    }
}
