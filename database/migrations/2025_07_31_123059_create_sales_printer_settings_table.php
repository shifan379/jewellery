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
        Schema::create('sales_printer_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('logo')->nullable();
            $table->longText('header_1')->nullable();
            $table->longText('header_2')->nullable();
            $table->longText('header_3')->nullable();
            $table->longText('header_4')->nullable();
            $table->longText('footer_1')->nullable();
            $table->longText('footer_2')->nullable();
            $table->longText('footer_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_printer_settings');
    }
};
