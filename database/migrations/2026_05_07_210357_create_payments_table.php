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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id'); // PK
            $table->foreignId('booking_id')->constrained('bookings', 'booking_id'); // FK
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_method'); // e.g., 'card' or 'ewallet'
            $table->timestamp('payment_date')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
