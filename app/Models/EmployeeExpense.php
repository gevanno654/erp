<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeExpense extends Model
{
    protected $fillable = [
        'employee_id',
        'expenses_type',
        'amount',
        'description',
        'expense_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
