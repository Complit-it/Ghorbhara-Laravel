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
        // Schema::create('gb_trn_properties', function (Blueprint $table) {
        //     $table->id()->autoIncrement();
        //     $table->string('title')->nullable();
        //     $table->integer('rooms')->nullable(); 
        //     $table->string('address')->nullable(); 
        //     $table->bigInteger('area')->nullable(); 
        //     $table->bigInteger('user_id')->unsigned()->nullable(); 
        //     $table->text('about')->nullable(); 
        //     $table->integer('property_type_id')->unsigned()->nullable(); 
        //     $table->timestamps();
        // });
        Schema::dropIfExists('properties');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
