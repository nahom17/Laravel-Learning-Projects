<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Order;
use App\Models\Accessory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAccessory extends Model
{
    use HasFactory;
    protected $table = "order_accessories";
    protected $fillable = [
        'order_id',
        'accessory_id',
        'product_id',
        'accessory_name',
        'price',
        'discount_price',
        'vat'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function accessory()
    {
        return $this->belongsTo(Accessory::class);
    }
}
