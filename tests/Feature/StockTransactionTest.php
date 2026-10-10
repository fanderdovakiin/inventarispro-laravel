<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_barang_masuk_menambah_stok_dan_mencatat_riwayat(): void
    {
        $user = $this->createAdmin();
        $product = Product::factory()->create(['stock' => 5]);

        $response = $this->actingAs($user)->post(
            route('stock.in.store'),
            [
                'product_id' => $product->product_id,
                'quantity' => 3,
                'notes' => 'Tes otomatis barang masuk',
            ]
        );

        $response->assertRedirect(route('stock.in.create'));

        $this->assertSame(8, (int) $product->fresh()->stock);

        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $product->product_id,
            'user_id' => $user->user_id,
            'quantity' => 3,
            'type' => 'IN',
            'stock_before' => 5,
            'stock_after' => 8,
        ]);
    }

    public function test_barang_keluar_mengurangi_stok_dan_mencatat_riwayat(): void
    {
        $user = $this->createAdmin();
        $product = Product::factory()->create(['stock' => 5]);

        $response = $this->actingAs($user)->post(
            route('stock.out.store'),
            [
                'product_id' => $product->product_id,
                'quantity' => 2,
                'notes' => 'Tes otomatis barang keluar',
            ]
        );

        $response->assertRedirect(route('stock.out.create'));

        $this->assertSame(3, (int) $product->fresh()->stock);

        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $product->product_id,
            'user_id' => $user->user_id,
            'quantity' => 2,
            'type' => 'OUT',
            'stock_before' => 5,
            'stock_after' => 3,
        ]);
    }

    public function test_barang_keluar_melebihi_stok_ditolak(): void
    {
        $user = $this->createAdmin();
        $product = Product::factory()->create(['stock' => 2]);

        $response = $this->actingAs($user)->post(
            route('stock.out.store'),
            [
                'product_id' => $product->product_id,
                'quantity' => 3,
                'notes' => 'Tes stok tidak mencukupi',
            ]
        );

        $response->assertSessionHasErrors('quantity');

        $this->assertSame(2, (int) $product->fresh()->stock);

        $this->assertDatabaseMissing('stock_movements', [
            'product_id' => $product->product_id,
            'type' => 'OUT',
        ]);
    }

    private function createAdmin(): User
    {
        return User::query()->create([
            'username' => 'admin-test-' . uniqid(),
            'password_hash' => 'password-test-123',
            'full_name' => 'Admin Pengujian',
            'role' => 'admin',
        ]);
    }
}