<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $primaryKey = 'stock_movement_id';

    protected $fillable = [
        'product_id',
        'user_id',
        'supplier_id',
        'quantity',
        'type',
        'stock_before',
        'stock_after',
        'movement_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'stock_before' => 'integer',
            'stock_after' => 'integer',
            'movement_date' => 'datetime',
        ];
    }

    /**
     * Produk yang mengalami perubahan stok.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class,
            'product_id',
            'product_id'
        );
    }

    /**
     * Pengguna yang melakukan transaksi.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'user_id'
        );
    }

    /**
     * Supplier terkait, jika transaksi memiliki supplier.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(
            Supplier::class,
            'supplier_id',
            'supplier_id'
        );
    }
}
