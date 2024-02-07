<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function admissions(): HasMany
    {
        return $this->hasMany(Admission::class);
    }
    public function consultations(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
