<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order_table';

    protected $primaryKey = 'order_id';

    protected $fillable = ['customer_name', 'employee_id'];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

}
