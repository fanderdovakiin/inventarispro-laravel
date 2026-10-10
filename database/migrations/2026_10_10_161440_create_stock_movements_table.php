<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id('stock_movement_id');

            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->restrictOnDelete();

            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->restrictOnDelete();

            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('suppliers', 'supplier_id')
                ->nullOnDelete();

            $table->unsignedInteger('quantity');
            $table->enum('type', ['IN', 'OUT']);

            $table->unsignedInteger('stock_before');
            $table->unsignedInteger('stock_after');

            $table->timestamp('movement_date')->useCurrent();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index([
                'product_id',
                'type',
                'movement_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
