<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan
    protected $table = 'inventories';

    // Kolom yang dapat diisi (fillable)
    protected $fillable = [
        'name_items',
        'type_items',
        'items_stock',
        'updated_stock_date',
    ];
}
