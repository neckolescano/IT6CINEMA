<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Movie extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'movie_id';

    protected $fillable = [
        'title',
        'genre',
        'runtime_minutes', // Keep this
        'rating',
        'release_date',
        'synopsis',        // Keep this
        'poster_url',
        'showing_status',  // Still in your DB for now
        'duration',        // Add for automated code
        'description',     // Add for automated code
    ];

    /**
     * Map 'duration' to 'runtime_minutes'
     */
    protected function duration(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['runtime_minutes'] ?? null,
            set: fn ($value) => ['runtime_minutes' => $value],
        );
    }

    /**
     * Map 'description' to 'synopsis'
     */
    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['synopsis'] ?? null,
            set: fn ($value) => ['synopsis' => $value],
        );
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'movie_id', 'movie_id');
    }
}