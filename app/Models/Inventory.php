<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $primaryKey = 'inventory_id';

    protected $fillable = [
        'item_id',
        'employee_id',
        'quantity',
        'status'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
