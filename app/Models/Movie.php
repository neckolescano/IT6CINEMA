<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies'; 
    protected $primaryKey = 'movie_id';
    protected $fillable = [
     'title', 'genre', 'runtime_minutes', 'rating', 
    'release_date', 'synopsis', 'poster_url', 'showing_status'
    ];
}
