<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id('movie_id'); // Primary Key 
            $table->string('title');
            $table->string('genre');
            $table->integer('runtime_minutes');
            $table->string('rating');
            $table->date('release_date');
            $table->text('synopsis');
            $table->string('poster_url')->nullable();
            $table->string('showing_status'); // e.g., "Now Showing" or "Coming Soon" [cite: 18, 82]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
