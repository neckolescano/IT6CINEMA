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
        Schema::create('seats', function (Blueprint $table) {
            $table->id('seat_id');
            
            // Use foreignId for custom IDs, but specify the correct constrained table and column
            $table->foreignId('cinema_id')
                ->constrained('cinemas', 'cinema_id') // table name, then custom column name
                ->onDelete('cascade');
                
            $table->string('seat_row');
            $table->integer('seat_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
