<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemList extends Model
{
    protected $table = 'item_list';

    protected $primaryKey = 'item_list_id';

    protected $fillable =['item_id', 'inventory_id', 'quantity', 'date_added', 'status'];

    public function item(): BelongsTo {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }

    public function inventory(): BelongsTo {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'inventory_id');
    }
}
