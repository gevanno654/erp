<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'name',
        'location',
        'name_product',
        'type_product',
        'stock_amount',
        'updated_stock_date',
    ];
}
