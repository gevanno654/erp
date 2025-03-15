<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'name',
        'department',
        'position',
        'manager',
        'employee_type',
        'email',
        'phone_number',
        'ktp_address',
        'ktp_city',
        'domicile_address',
        'domicile_city',
        'bank_account',
        'net_salary',
        'nationality',
        'ktp_number',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'marital_status',
        'spouse_complete_name',
        'number_of_dependent_children',
        'educational_level',
        'field_of_study',
        'school',
    ];

    protected static function boot()
    {
        parent::boot();

        // Soft delete User ketika Employee dihapus
        static::deleting(function ($employee) {
            if ($employee->user) {
                $employee->user->delete();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Employee.php
    public function workShifts()
    {
        return $this->belongsToMany(WorkShift::class, 'employee_work_shift', 'employee_id', 'work_shift_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function employeeExpenses()
    {
        return $this->hasMany(EmployeeExpense::class);
    }
}
