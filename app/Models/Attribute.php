<?php

namespace App\Models;
use App\Models\Accessory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $table = 'attributes';
    protected $fillable = [
        'id',
        'name',

    ];
    public function accessories()
    {
        return $this->hasMany(Accessory::class);
    }
}
