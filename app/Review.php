<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'review', 'movie', 'user_id'
    ];

    public function movie() {
        return $this->belongsTo('App\Movie');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
