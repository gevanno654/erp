<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'stock',
        'price_per_ton',
        'stock_updated_at'
    ];

    protected $casts = [
        'stock_updated_at' => 'datetime',
    ];
}
