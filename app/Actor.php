<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'movie'
    ];

    public function movie() {
        return $this->belongsTo('App\Movie');
    }

}
