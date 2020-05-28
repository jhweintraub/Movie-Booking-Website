<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seatCount', 'seatNumber', 'rowCount'
    ];

    public function Showings() {
        return $this->hasMany('App\Showing');
    }

    public function tickets() {
        return $this->hasMany('App\Ticket');
    }
}
