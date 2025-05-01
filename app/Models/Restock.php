<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'restocks';

    protected $fillable = [
        'product_id', // Changed from id_items
        'employee_id',
        'restock_amount',
        'date',
        'status',
    ];

    public function product() // Changed from inventory
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
