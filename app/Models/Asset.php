<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'asset_name',
        'asset_type',
        'purchase_date',
        'purchase_price',
        'depreciation_method',
        'useful_life',
        'salvage_value',
    ];
}
