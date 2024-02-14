<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderProduct extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = "orders_products";
    protected $fillable = [
        'product_id',
        'order_id',
        'quantity',
        'price_excl',
        'discount_price',

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
