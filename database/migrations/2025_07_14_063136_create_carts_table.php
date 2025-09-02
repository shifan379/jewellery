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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('discount_type')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->string('sales_type')->default('retail');
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('net_price', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->virtualAs('quantity * net_price');
             // Added virtual column for total
            $table->decimal('main_sub_total', 10, 2)->nullable();
            $table->decimal('main_discount', 10, 2)->nullable();
            $table->decimal('main_total', 10, 2)->nullable();



            $table->integer('return')->default(0);
            $table->string('original_order_item_id')->nullable();
            $table->decimal('main_return_amount', 8, 2)->default(0.00);

            // Foreign key
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
