<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    protected $fillable = ['product_name', 'product_description', 'product_price', 'stock_quantity', 'status'];
}
