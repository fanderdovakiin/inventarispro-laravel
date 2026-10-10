<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'contact_info',
        'location',
        'email',
        'phone',
    ];

    /**
     * Produk yang dipasok oleh supplier ini.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_suppliers',
            'supplier_id',
            'product_id',
            'supplier_id',
            'product_id'
        )->withPivot([
                    'product_supplier_id',
                    'quantity_supplied',
                    'supplier_price',
                    'is_primary',
                    'lead_time_days',
                ])->withTimestamps();
    }

    /**
     * Histori transaksi stok yang mencatat supplier ini.
     */
    public function stockMovements(): HasMany
    {
        return $this->hasMany(
            StockMovement::class,
            'supplier_id',
            'supplier_id'
        );
    }
}
