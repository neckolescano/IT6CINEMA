<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_payments', function (Blueprint $table) {
            $table->foreignId('payment_id')->primary()->constrained('payments', 'payment_id')->onDelete('cascade');
            $table->string('card_network'); // e.g., Visa, Mastercard
            $table->string('authorization_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_payments');
    }
};
