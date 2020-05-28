<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'taken', 'showing'
    ];



    public function Showings() {
        return $this->belongsTo('App\Showing');
    }

    public function Ticket() {
        return $this->hasOne('App\Ticket');
    }
}
