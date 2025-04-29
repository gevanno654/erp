<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'month_year',
        'transaction_type',
        'description',
        'amount',
        'debit_account',
        'credit_account'
    ];

    protected $dates = ['transaction_date'];

    protected $casts = [
        'transaction_date' => 'date',
    ];
}
