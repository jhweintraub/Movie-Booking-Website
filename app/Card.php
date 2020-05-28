<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Card extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nameOnCard', 'expDate', 'cardNumber', 'cvv', 'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function bookings() {
        return $this->hasMany('App\Booking');
    }
}
