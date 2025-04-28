<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Attendance extends Model
{
    protected $table = 'employee_attendance';

    protected $fillable = ['employee_id', 'time_in', 'time_out', 'remark'];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
