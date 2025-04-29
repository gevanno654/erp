<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'type',
        'all_stock',
    ];

    public function inventories(): BelongsToMany
    {
        return $this->belongsToMany(Inventory::class, 'inventory_product')
            ->withPivot('stock_amount', 'updated_stock_date')
            ->withTimestamps();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
