<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalValue = Product::query()
            ->selectRaw(
                'COALESCE(SUM(stock * price), 0) AS total'
            )
            ->value('total');

        $lowStockCount = Product::query()
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->where('stock', '>', 0)
            ->count();

        $outOfStockCount = Product::where('stock', 0)
            ->count();

        $totalIn = StockMovement::where('type', 'IN')
            ->sum('quantity');

        $totalOut = StockMovement::where('type', 'OUT')
            ->sum('quantity');

        $recentMovements = StockMovement::with([
            'product',
            'user',
        ])
            ->orderByDesc('movement_date')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalValue',
            'lowStockCount',
            'outOfStockCount',
            'totalIn',
            'totalOut',
            'recentMovements'
        ));
    }
}