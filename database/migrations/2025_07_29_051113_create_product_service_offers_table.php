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
        Schema::create('product_service_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->integer('free_service_count');
            $table->integer('validity_days'); // e.g., 365 days
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_service_offers');
    }
};
