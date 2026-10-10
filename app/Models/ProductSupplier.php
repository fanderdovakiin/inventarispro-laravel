<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSupplier extends Model
{
    use HasFactory;

    protected $table = 'product_suppliers';

    protected $primaryKey = 'product_supplier_id';

    protected $fillable = [
        'product_id',
        'supplier_id',
        'quantity_supplied',
        'supplier_price',
        'is_primary',
        'lead_time_days',
    ];

    protected function casts(): array
    {
        return [
            'quantity_supplied' => 'integer',
            'supplier_price' => 'decimal:2',
            'is_primary' => 'boolean',
            'lead_time_days' => 'integer',
        ];
    }

    /**
     * Produk yang terkait dengan supplier ini.
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
     * Supplier yang terkait dengan produk ini.
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
