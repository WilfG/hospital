<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['drug_id', 'quantity', 'sale_price', 'sale_date', 'material_id'];

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
