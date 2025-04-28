<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    protected $primaryKey = 'employee_id';

    protected $fillable = ['employee_name', 'email', 'phone', 'address', 'position', 'hire_date'];

    public function login() {
        return $this->hasOne(Employee_Login::class, 'employee_id', 'employee_id');
    }

    public function attendance() {
        return $this->hasMany(Employee_Attendance::class, 'employee_id', 'employee_id');
    }
}
