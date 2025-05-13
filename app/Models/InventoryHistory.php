<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryHistory extends Model
{
    use HasFactory;

    protected $table = 'inventory_history';

    // Allow mass assignment
    protected $fillable = [
        'item_id',
        'status',
    ];

    /**
     * Get the item related to this inventory history entry.
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}