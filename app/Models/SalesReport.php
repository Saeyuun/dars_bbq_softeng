<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReport extends Model
{
    protected $table = 'sales_report';

    protected $primaryKey = 'sales_id';
    protected $fillable = ['cost_id',   'employee_id', 'total_sales',];
    
    public function costReport() {
        return $this->belongsTo(CostReport::class, 'cost_id', 'cost_id');
    }
}
