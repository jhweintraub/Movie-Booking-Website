<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dateTime', 'user', 'card_id', 'user_id', 'bookingNumber'
    ];

    protected $casts = [
        'dateTime' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function card() {
        return $this->belongsTo('App\Card');
    }

    public function ticket() {
        return $this->hasMany('App\Ticket');
    }
}
