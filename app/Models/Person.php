<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';

    protected $fillable = [

        'name',
        'address',
        'zip_code',
        'phone_number',
        'email',
    ];

    public function companies()
    {
        return $this->hasMany(CompanyPerson::class);
    }
}
