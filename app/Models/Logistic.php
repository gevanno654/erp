<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logistic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fleet_number',
        'order_id',
        'order_date',
        'estimated_completion_date',
        'mitra_id',
        'destination_address',
        'product_id',
        'delivered_quantity',
        'departure_time',
        'delivered_time',
        'status'
    ];

    protected $dates = [
        'order_date',
        'estimated_completion_date',
        'departure_time',
        'delivered_time',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'order_date' => 'date',
        'estimated_completion_date' => 'date',
        'departure_time' => 'datetime',
        'delivered_time' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
