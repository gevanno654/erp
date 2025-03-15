<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkShift extends Model
{
    use SoftDeletes;

    protected $table = 'works_shifts';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'employee_id',
        'name_day',
        'name_shift',
        'work_start',
        'work_finish',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_work_shift', 'work_shift_id', 'employee_id')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }
}
