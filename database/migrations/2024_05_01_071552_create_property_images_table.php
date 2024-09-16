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
        // Schema::create('gb_trn_property_images', function (Blueprint $table) {
        //     $table->id()->autoIncrement();
        //     $table->bigInteger('prop_id')->unsigned()->nullable(); // Foreign key referencing property table
        //     $table->string('image_path')->nullable(); // VARCHAR with null values allowed
        //     $table->boolean('is_main')->nullable();
        //     $table->timestamps();
        // });
        Schema::dropIfExists('property_images');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_images');
    }
};
