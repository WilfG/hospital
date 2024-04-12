<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'drug_id', 'material_id', 'quantity', 'cost', 'purchase_date'];

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
