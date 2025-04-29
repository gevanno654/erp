<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'salary_id',
        'date',
        'month_year',
        'employee_id',
        'attendance_count',
        'incentive',
        'total_salary'
    ];

    protected $dates = ['date'];

    protected $casts = [
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($salary) {
            // Generate salary_id format: GBK10100001
            $latest = Salary::orderBy('id','DESC')->first();
            $increment = $latest ? intval(substr($latest->salary_id, 7)) + 1 : 1;
            $salary->salary_id = 'GBK101' . str_pad($increment, 5, '0', STR_PAD_LEFT);
        });
    }
}
