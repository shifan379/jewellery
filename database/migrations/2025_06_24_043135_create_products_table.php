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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('location')->nullable();
            $table->string('product_name');
            $table->string('prefix')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('unit')->nullable();
            $table->string('mark')->nullable();
            $table->integer('product_type')->nullable()->comment('1 => single product, 2 => variable products. its for add mulitypule items using same name');

            // if single product
            $table->string('discount_percentage')->nullable();
            $table->string('discount_amount')->nullable();

            //if mulity products
            $table->string('item_code')->nullable();
            $table->string('quantity')->nullable();
            $table->decimal('weight',15, 2)->nullable();
            $table->decimal('buying_price',15, 2)->nullable();
            $table->string('images')->nullable();

            // Seller
            $table->integer('supplier_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
