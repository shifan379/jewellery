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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_no')->unique();
            $table->unsignedBigInteger('orderID')->comment('Reference to order');
            $table->decimal('total', 10, 2)->default(0.00);
            $table->decimal('total_recived', 10, 2)->default(0.00);
            $table->decimal('change', 10, 2)->default(0.00);
             $table->integer('card_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->foreign('orderID')->references('id')->on('orders')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
