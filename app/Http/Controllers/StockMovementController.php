<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StockMovementController extends Controller
{
    /**
     * Menampilkan histori pergerakan stok dengan filter dan pagination.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'product_id' => [
                'nullable',
                'integer',
                Rule::exists('products', 'product_id'),
            ],
            'type' => [
                'nullable',
                Rule::in(['IN', 'OUT']),
            ],
            'user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'user_id'),
            ],
            'date_from' => [
                'nullable',
                'date',
            ],
            'date_to' => [
                'nullable',
                'date',
                'after_or_equal:date_from',
            ],
        ]);

        $movements = StockMovement::query()
            ->with(['product', 'user', 'supplier'])
            ->when(
                !empty($filters['product_id']),
                fn($query) => $query->where(
                    'product_id',
                    $filters['product_id']
                )
            )
            ->when(
                !empty($filters['type']),
                fn($query) => $query->where(
                    'type',
                    $filters['type']
                )
            )
            ->when(
                !empty($filters['user_id']),
                fn($query) => $query->where(
                    'user_id',
                    $filters['user_id']
                )
            )
            ->when(
                !empty($filters['date_from']),
                fn($query) => $query->whereDate(
                    'movement_date',
                    '>=',
                    $filters['date_from']
                )
            )
            ->when(
                !empty($filters['date_to']),
                fn($query) => $query->whereDate(
                    'movement_date',
                    '<=',
                    $filters['date_to']
                )
            )
            ->orderByDesc('movement_date')
            ->orderByDesc('stock_movement_id')
            ->paginate(10)
            ->withQueryString();

        $products = Product::query()
            ->orderBy('product_name')
            ->get([
                'product_id',
                'sku',
                'product_name',
            ]);

        $users = User::query()
            ->orderBy('full_name')
            ->get([
                'user_id',
                'full_name',
            ]);

        return view('stock.history', compact(
            'movements',
            'products',
            'users',
            'filters'
        ));
    }
}
