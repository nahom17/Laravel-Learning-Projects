<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\OrderAccessory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory extends Model
{
    use HasFactory;
    protected $table = 'accessories';
    protected $fillable = [
        'product_id',
        'attribute_id',
        'name',
        'image',
        'price',
        'discount_price',
        'vat'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function orders()
    {
        return $this->hasMany(OrderAccessory::class);
    }
}
