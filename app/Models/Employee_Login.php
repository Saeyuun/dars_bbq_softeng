<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee_Login extends Model {
    protected $table = 'employee_login';

    protected $fillable = ['employee_id', 'username', 'password', 'permission'];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
