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
        // Schema::create('gb_mst_home_facilities', function (Blueprint $table) {
        //     $table->id()->autoIncrement();
        //     $table->string('facility')->nullable();
        //     $table->timestamps();
        // });

        Schema::dropIfExists('home_facilities');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_facilities');
    }
};
