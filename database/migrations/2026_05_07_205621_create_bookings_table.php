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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id('booking_id'); // PK from your ERD
            $table->foreignId('customer_id')->constrained('customer_profiles', 'customer_id'); // FK
            $table->foreignId('schedule_id')->constrained('schedules', 'schedule_id'); // FK
            $table->decimal('total_amount', 10, 2);
            $table->string('status')->default('confirmed');
            $table->timestamp('booking_time')->useCurrent();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
