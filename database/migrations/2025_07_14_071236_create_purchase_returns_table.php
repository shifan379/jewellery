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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date');
            $table->text('notes')->nullable();
            $table->integer('product_id');
            $table->integer('purcheseID');
            $table->integer('qty');
            $table->decimal('purchase_price')->default(0.00);
            $table->decimal('weight')->default(0.00);
            $table->decimal('unit_cost')->default(0.00);
            $table->decimal('total')->default(0.00);
            $table->decimal('return_total')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
