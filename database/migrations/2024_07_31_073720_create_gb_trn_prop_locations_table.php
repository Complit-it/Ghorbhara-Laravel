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
        Schema::create('gb_trn_prop_locations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('prop_id');
            $table->string('location_name')->nullable();
            $table->text('description')->nullable();
            $table->string('latitude')->nullable(); // Change datatype to string
            $table->string('longitude')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gb_trn_prop_locations');
    }
};
