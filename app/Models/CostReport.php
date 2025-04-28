<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CostReport extends Model
{
    protected $table = 'cost_report';

    protected $primaryKey = 'cost_id';

    protected $fillable = ['inventory_id', 'employee_id', 'total_cost'];

    public function inventory(): BelongsTo {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }
}
