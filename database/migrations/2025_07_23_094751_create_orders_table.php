<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique()->comment('Unique invoice number');
            $table->unsignedBigInteger('customer_id')->nullable()->comment('Foreign key to customers');
            $table->string('phone_number')->nullable()->comment('Customer phone number');
            $table->string('discount_type')->nullable();
             $table->string('sales_type')->nullable();
            $table->decimal('subtotal', 10, 2)->default(0.00)->comment('Total before discount');
            $table->decimal('discount', 10, 2)->default(0.00)->comment('Total discount');
            $table->decimal('total', 10, 2)->default(0.00)->comment('Total after discount');
            $table->integer('cashier_id')->nullable()->comment('User ID of cashier');
             $table->decimal('return_amount')->default(0.00);
            $table->string('order_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
