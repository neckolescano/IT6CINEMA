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
       Schema::create('ewallet_payments', function (Blueprint $table) {
            $table->foreignId('payment_id')->primary()->constrained('payments', 'payment_id')->onDelete('cascade');
            $table->string('provider_name'); // e.g., GCash, Maya
            $table->string('reference_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ewallet_payments');
    }
};
