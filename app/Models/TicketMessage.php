<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'user_id', // User who posted the message
        'content', 
        'parent_id'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Parent message
    public function parent() {
        return $this->belongsTo(TicketMessage::class, 'parent_id');
    }

    // Child replies
    public function replies() {
        return $this->hasMany(TicketMessage::class, 'parent_id');
    }
}
