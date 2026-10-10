<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Kategori
        |--------------------------------------------------------------------------
        */

        $categoryData = [
            'Elektronik' => 'Perangkat elektronik.',
            'Aksesoris Komputer' => 'Aksesoris komputer dan perangkat.',
            'Furniture' => 'Perabot dan perlengkapan.',
            'Alat Tulis Kantor' => 'Alat tulis dan perlengkapan kantor.',
            'Suku Cadang' => 'Komponen dan suku cadang.',
        ];

        foreach ($categoryData as $name => $description) {
            Category::updateOrCreate(
                ['category_name' => $name],
                [
                    'description' => $description,
                    'slug' => Str::slug($name),
                ]
            );
        }

        $categories = Category::all();

        if ($categories->isEmpty()) {
            throw new RuntimeException(
                'Kategori gagal dibuat.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Supplier
        |--------------------------------------------------------------------------
        */

        if (Supplier::count() === 0) {
            Supplier::factory()->count(5)->create();
        }

        $suppliers = Supplier::all();

        if ($suppliers->isEmpty()) {
            throw new RuntimeException(
                'Data supplier belum tersedia.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 3. Akun Admin dan Staff
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@example.com',
                'password_hash' => Hash::make('admin123'),
                'full_name' => 'Administrator',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['username' => 'staff'],
            [
                'email' => 'staff@example.com',
                'password_hash' => Hash::make('staff123'),
                'full_name' => 'Staff Gudang',
                'role' => 'staff',
            ]
        );

        // Ambil user_id admin langsung dari database.
        $adminId = User::query()
            ->where('username', 'admin')
            ->value('user_id');

        if ($adminId === null) {
            throw new RuntimeException(
                'Akun admin tidak ditemukan atau user_id kosong.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Produk
        |--------------------------------------------------------------------------
        */

        if (Product::count() === 0) {
            Product::factory()
                ->count(20)
                ->state(fn() => [
                    'category_id' => $categories
                        ->random()
                        ->category_id,
                ])
                ->create();
        }

        $products = Product::all();

        /*
        |--------------------------------------------------------------------------
        | 5. Relasi Produk dan Supplier
        |--------------------------------------------------------------------------
        */

        foreach ($products as $product) {
            // Jangan membuat pasangan produk-supplier duplikat.
            if ($product->suppliers()->exists()) {
                continue;
            }

            $selectedSuppliers = $suppliers
                ->shuffle()
                ->take(
                    random_int(
                        1,
                        min(3, $suppliers->count())
                    )
                )
                ->values();

            $pivotData = [];

            foreach ($selectedSuppliers as $index => $supplier) {
                $pivotData[$supplier->supplier_id] = [
                    'quantity_supplied' => random_int(10, 100),
                    'supplier_price' => round(
                        (float) $product->price * 0.75,
                        2
                    ),
                    'is_primary' => $index === 0,
                    'lead_time_days' => random_int(1, 14),
                ];
            }

            $product->suppliers()
                ->syncWithoutDetaching($pivotData);
        }

        /*
        |--------------------------------------------------------------------------
        | 6. Histori Stok Awal
        |--------------------------------------------------------------------------
        */

        foreach ($products as $product) {
            // Lewati produk yang sudah memiliki histori.
            if ($product->stockMovements()->exists()) {
                continue;
            }

            // Produk dengan stok nol tidak memerlukan
            // histori barang masuk awal.
            if ((int) $product->stock <= 0) {
                continue;
            }

            // Gunakan supplier utama jika tersedia.
            $supplierId = $product->suppliers()
                ->wherePivot('is_primary', true)
                ->value('suppliers.supplier_id');

            // Jika belum ada supplier utama, gunakan supplier pertama.
            if ($supplierId === null) {
                $supplierId = $product->suppliers()
                    ->value('suppliers.supplier_id');
            }

            // Relasi otomatis mengisi product_id.
            $product->stockMovements()->create([
                'user_id' => $adminId,
                'supplier_id' => $supplierId,
                'quantity' => $product->stock,
                'type' => 'IN',
                'stock_before' => 0,
                'stock_after' => $product->stock,
                'movement_date' => now(),
                'notes' => 'Stok awal data demo.',
            ]);
        }
    }
}
