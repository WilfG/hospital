<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'firstname',
    //     'lastname',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function role(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function ticketsOwned() : HasMany
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function tikets(): BelongsToMany
    {
        return $this->belongsToMany(Ticket::class, 'ticket_user');
    } 
    
    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    } 
    public function stockmovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    } 
}
