<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');

            $table->foreignId('category_id')
                ->constrained('categories', 'category_id')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('sku', 50)->unique();
            $table->string('product_name', 150);
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('stock')->default(0);
            $table->integer('minimum_stock')->default(5);
            $table->date('expiry_date')->nullable();

            $table->timestamps();

            $table->index('product_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};