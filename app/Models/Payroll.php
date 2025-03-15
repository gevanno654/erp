<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = [
        'employee_id',
        'salary',
        'tax',
        'deductions',
        'net_salary',
        'payment_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
