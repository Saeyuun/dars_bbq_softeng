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
        'status',
        'created_at',
        'updated_at'
    ];

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function history() {
        return $this->hasMany(InventoryHistory::class, 'inventory_id', 'inventory_id');
    }
}
