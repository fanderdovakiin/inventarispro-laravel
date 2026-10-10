<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_suppliers', function (Blueprint $table) {
            $table->id('product_supplier_id');

            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->cascadeOnDelete();

            $table->foreignId('supplier_id')
                ->constrained('suppliers', 'supplier_id')
                ->cascadeOnDelete();

            $table->integer('quantity_supplied')->nullable();
            $table->decimal('supplier_price', 12, 2)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('lead_time_days')->nullable();

            $table->timestamps();

            // Satu pasangan produk-supplier hanya boleh tercatat sekali.
            $table->unique(['product_id', 'supplier_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_suppliers');
    }
};
