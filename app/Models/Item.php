<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    protected $primaryKey = 'item_id';

    protected $fillable = [
        'item_name',
        'description',
        'unit'
    ];

    public function inventory() {
        return $this->hasOne(Inventory::class, 'item_id', 'item_id');
    }

    public function itemlist() {
        return $this->hasMany(ItemList::class, 'item_id', 'item_id');
    }
}
