<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Products';

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'discount_price',
        'vat',
    ];

    public function orders()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function accessories()
    {
        return $this->hasMany(Accessory::class);
    }
}
