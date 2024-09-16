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
        Schema::create('gb_trn_booking_details', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('prop_id');
            $table->string('order_id');
            $table->string('payment_id');
            $table->string('booking_date');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gb_trn_booking_details');
    }
};
