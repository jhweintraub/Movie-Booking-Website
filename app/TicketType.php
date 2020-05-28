<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'Name', 'Amount'
    ];

    public function tickets() {
        return $this->hasMany('App\Ticket');
    }
}
