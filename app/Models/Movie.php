<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies'; 
    protected $primaryKey = 'movie_id';
    
    // Ensure all these exactly match your DB column names
    protected $fillable = [
        'title', 
        'genre', 
        'runtime_minutes', 
        'rating', 
        'release_date', 
        'synopsis', 
        'poster_url', 
        'showing_status'
    ];
}
