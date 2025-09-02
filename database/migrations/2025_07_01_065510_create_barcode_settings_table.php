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
        Schema::create('barcode_settings', function (Blueprint $table) {
            $table->id();
            $table->string('label_name')->nullable();
            $table->json('fields')->nullable();
            $table->string('barcode_width')->nullable();
            $table->string('barcode_hight')->nullable();
            $table->string('font_size')->nullable();
            $table->string('font_family')->nullable();
            $table->string('label_width')->nullable();
            $table->string('label_hight')->nullable();
            $table->string('lable_count_row')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barcode_settings');
    }
};
