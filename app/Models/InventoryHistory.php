<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    protected $table = 'inventory_history';

    protected $fillable = [
        'inventory_id',
        'changes',
        'quantity_at_time',
        'status_at_time'
    ];

    // Primary key
    protected $primaryKey = 'id';

    // Relationships
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }

}
