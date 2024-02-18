<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'name',
        'address',
        'zip_code',
        'city',
        'email',
        'phone_number',
        'total_vat',
        'total_price_excl',
        'total_amount',
        'status',

    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function accessories()
    {
        return $this->hasMany(OrderAccessory::class);
    }
}
