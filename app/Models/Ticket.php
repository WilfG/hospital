<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status', // Add status (e.g., open, closed, pending)
        'priority', // Add priority (e.g., low, medium, high)
        'created_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
