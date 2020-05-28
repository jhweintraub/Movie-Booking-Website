<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'email', 'isAdmin', 'address', 'promotion_opt_in'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cards() {
        return $this->hasMany('App\Card');
    }

    public function bookings() {
        return $this->hasMany('App\Booking');
    }

    public function seats() {
        return $this->hasMany('App\Seat');
    }

    public function tickets() {
        return $this->hasMany('App\Ticket');
    }

    public function reviews() {
        return $this->hasMany('App\Review');
    }

    public function findForPassport($identifier) {
        return User::orWhere(‘email’, $identifier)->where(‘status’, 1)->first();
    }
}
