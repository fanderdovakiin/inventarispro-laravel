<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockInController extends Controller
{
    /**
     * Menampilkan form transaksi barang masuk.
     */
    public function create()
    {
        $products = Product::query()
            ->orderBy('product_name')
            ->get([
                'product_id',
                'sku',
                'product_name',
                'stock',
            ]);

        $suppliers = Supplier::query()
            ->orderBy('supplier_name')
            ->get([
                'supplier_id',
                'supplier_name',
            ]);

        return view('stock.in', compact(
            'products',
            'suppliers'
        ));
    }

    /**
     * Memproses barang masuk dan mencatat histori secara atomik.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'product_id'),
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'supplier_id' => [
                'nullable',
                'integer',
                Rule::exists('suppliers', 'supplier_id'),
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            // Kunci baris produk selama transaksi berlangsung.
            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($validated['product_id']);

            $stockBefore = (int) $product->stock;
            $quantity = (int) $validated['quantity'];
            $stockAfter = $stockBefore + $quantity;

            // Perbarui stok produk.
            $product->stock = $stockAfter;
            $product->save();

            // Catat perubahan stok pada histori.
            StockMovement::create([
                'product_id' => $product->product_id,
                'user_id' => auth()->id(),
                'supplier_id' => $validated['supplier_id'] ?? null,
                'quantity' => $quantity,
                'type' => 'IN',
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'movement_date' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('stock.in.create')
            ->with(
                'success',
                'Transaksi barang masuk berhasil disimpan.'
            );
    }
}
