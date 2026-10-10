<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class StockOutController extends Controller
{
    /**
     * Menampilkan form transaksi barang keluar.
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

        return view('stock.out', compact('products'));
    }

    /**
     * Memproses barang keluar dengan pemeriksaan stok.
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
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($validated) {
            // Kunci baris produk agar transaksi bersamaan
            // tidak menggunakan nilai stok yang sudah usang.
            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($validated['product_id']);

            $stockBefore = (int) $product->stock;
            $quantity = (int) $validated['quantity'];

            // Barang keluar tidak boleh melebihi stok.
            if ($quantity > $stockBefore) {
                throw ValidationException::withMessages([
                    'quantity' => sprintf(
                        'Stok tidak cukup. Stok tersedia: %d unit.',
                        $stockBefore
                    ),
                ]);
            }

            $stockAfter = $stockBefore - $quantity;

            // Perbarui stok produk.
            $product->stock = $stockAfter;
            $product->save();

            // Catat histori transaksi barang keluar.
            StockMovement::create([
                'product_id' => $product->product_id,
                'user_id' => auth()->id(),
                'supplier_id' => null,
                'quantity' => $quantity,
                'type' => 'OUT',
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'movement_date' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('stock.out.create')
            ->with(
                'success',
                'Transaksi barang keluar berhasil disimpan.'
            );
    }
}
