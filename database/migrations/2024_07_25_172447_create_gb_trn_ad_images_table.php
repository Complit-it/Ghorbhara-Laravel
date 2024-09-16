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
        Schema::create('gb_trn_ad_images', function (Blueprint $table) {
            $table->id();
            $table->integer('ad_id')->nullable();
            $table->string('image_path')->nullable();
            $table->string('is_main')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gb_trn_ad_images');
    }
};
