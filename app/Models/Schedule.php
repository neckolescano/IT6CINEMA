<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    // Explicitly set the primary key from your ERD
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'movie_id', 
        'cinema_id', 
        'show_datetime', 
        'base_ticket_price'
    ];

    protected $casts = [
        'show_datetime' => 'datetime',
    ];

    /**
     * Relationship to Movie.
     * Explicitly defining 'movie_id' as both foreign and local key.
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }

    /**
     * Relationship to Cinema.
     * Explicitly defining 'cinema_id' to match your database structure.
     */
    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class, 'cinema_id', 'cinema_id');
    }

    /**
     * Logic updated to use show_datetime from ERD.
     * This determines the status based on current time.
     */
    public function getStatusAttribute()
    {
        $now = now();
        $start = $this->show_datetime;
        
        // We'll estimate the movie duration (e.g., 2.5 hours) 
        // to determine if it's "Now Showing" or "Past"
        $estimatedEnd = (clone $start)->addMinutes(150); 

        if ($now->lt($start)) {
            return 'UPCOMING';
        } elseif ($now->between($start, $estimatedEnd)) {
            return 'NOW SHOWING';
        } else {
            return 'PAST SHOW';
        }
    }
}