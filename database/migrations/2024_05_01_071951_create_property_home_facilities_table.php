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
        // Schema::create('gb_trn_property_home_facilities', function (Blueprint $table) {
        //     $table->id()->autoIncrement();
        //     $table->bigInteger('prop_id')->unsigned()->nullable(); 
        //     $table->bigInteger('home_facility_id')->unsigned()->nullable();
        //     $table->timestamps();
        // });
        Schema::dropIfExists('property_home_facilities');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_home_facilities');
    }
};
