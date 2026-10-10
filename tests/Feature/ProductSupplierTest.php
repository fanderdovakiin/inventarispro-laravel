<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductSupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product_with_multiple_suppliers(): void
    {
        $admin = $this->createAdmin();
        $firstSupplier = Supplier::factory()->create();
        $secondSupplier = Supplier::factory()->create();

        $response = $this->actingAs($admin)->post(
            route('products.store'),
            [
                'sku' => 'TEST-SUPPLIER-001',
                'product_name' => 'Produk Pengujian Pemasok',
                'category_id' => \App\Models\Category::factory()->create()->category_id,
                'price' => 150000,
                'minimum_stock' => 5,
                'supplier_selection_submitted' => '1',
                'supplier_ids' => [
                    $firstSupplier->supplier_id,
                    $secondSupplier->supplier_id,
                ],
            ]
        );

        $response->assertRedirect(route('products.index'));

        $product = Product::where('sku', 'TEST-SUPPLIER-001')->firstOrFail();

        $this->assertSame(0, (int) $product->stock);

        $this->assertDatabaseHas('product_suppliers', [
            'product_id' => $product->product_id,
            'supplier_id' => $firstSupplier->supplier_id,
        ]);

        $this->assertDatabaseHas('product_suppliers', [
            'product_id' => $product->product_id,
            'supplier_id' => $secondSupplier->supplier_id,
        ]);

        $this->assertCount(2, $product->suppliers);
    }

    public function test_admin_can_update_product_suppliers_without_changing_stock(): void
    {
        $admin = $this->createAdmin();
        $product = Product::factory()->create(['stock' => 17]);

        $oldSupplier = Supplier::factory()->create();
        $newSupplier = Supplier::factory()->create();

        $product->suppliers()->sync([
            $oldSupplier->supplier_id,
        ]);

        $response = $this->actingAs($admin)->put(
            route('products.update', $product),
            [
                'sku' => $product->sku,
                'product_name' => $product->product_name,
                'category_id' => $product->category_id,
                'description' => $product->description,
                'price' => $product->price,
                'minimum_stock' => $product->minimum_stock,
                'expiry_date' => $product->expiry_date?->format('Y-m-d'),
                'supplier_selection_submitted' => '1',
                'supplier_ids' => [
                    $newSupplier->supplier_id,
                ],
            ]
        );

        $response->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('product_suppliers', [
            'product_id' => $product->product_id,
            'supplier_id' => $oldSupplier->supplier_id,
        ]);

        $this->assertDatabaseHas('product_suppliers', [
            'product_id' => $product->product_id,
            'supplier_id' => $newSupplier->supplier_id,
        ]);

        $this->assertSame(17, (int) $product->fresh()->stock);
        $this->assertCount(1, $product->fresh()->suppliers);
    }

    private function createAdmin(): User
    {
        return User::query()->create([
            'username' => 'supplier-test-' . uniqid(),
            'password_hash' => Hash::make('password-test-123'),
            'full_name' => 'Admin Pengujian',
            'role' => 'admin',
        ]);
    }
}
