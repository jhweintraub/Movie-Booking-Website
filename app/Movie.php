<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Movie extends Model
{
    use SearchableTrait;

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'movies.title' => 10,
            'movies.director' => 5,
            'movies.id' => 3,
            'movies.category' => 5
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'category', 'director', 'producer', 'synopsis'
        ,'pictureLink', 'videoLink', 'rating', 'duration', 'is_active'
    ];

    public function actors() {
        return $this->hasMany('App\Actor');
    }

    public function reviews() {
        return $this->hasMany('App\Review');
    }

    public function showings() {
        return $this->hasMany('App\Showing');
    }

}
