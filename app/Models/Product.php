<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'category_id',
        'sku',
        'product_name',
        'description',
        'price',
        'stock',
        'minimum_stock',
        'expiry_date',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer',
            'minimum_stock' => 'integer',
            'expiry_date' => 'date',
        ];
    }

    /**
     * Setiap produk memiliki satu kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }

    /**
     * Satu produk dapat memiliki banyak supplier.
     */
    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(
            Supplier::class,
            'product_suppliers',
            'product_id',
            'supplier_id',
            'product_id',
            'supplier_id'
        )->withPivot([
                    'product_supplier_id',
                    'quantity_supplied',
                    'supplier_price',
                    'is_primary',
                    'lead_time_days',
                ])->withTimestamps();
    }

    /**
     * Histori barang masuk dan barang keluar.
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(
            StockMovement::class,
            'product_id',
            'product_id'
        );
    }

    /**
     * Menentukan apakah stok produk rendah.
     */
    public function isLowStock(): bool
    {
        return $this->stock <= $this->minimum_stock;
    }

    /**
     * Menentukan apakah stok produk habis.
     */
    public function isOutOfStock(): bool
    {
        return $this->stock === 0;
    }
}
