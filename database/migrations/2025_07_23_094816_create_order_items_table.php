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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orderID');
            $table->unsignedBigInteger('productID');
            $table->integer('qty')->default(0);
            $table->decimal('weight')->default(0);
            $table->decimal('net_price')->default(0.00);
            $table->decimal('discount')->default(0.00);
            $table->decimal('total')->default(0.00);

            $table->foreign('orderID')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('productID')->references('id')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
