<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [

        'name',
        'address',
        'zip_code',
        'phone_number',
        'email',
    ];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
