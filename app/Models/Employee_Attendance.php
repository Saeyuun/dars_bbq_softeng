<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Attendance extends Model
{
    protected $table = 'employee_attendance';
    public $timestamps = false;
    protected $primaryKey = 'login_id';

    protected $fillable = ['employee_id', 'time_in', 'time_out', 'remark'];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
