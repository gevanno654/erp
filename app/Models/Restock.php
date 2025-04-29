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
        'id_items',
        'employee_id',
        'restock_amount',
        'date',
        'status',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'id_items');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
