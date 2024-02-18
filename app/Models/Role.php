<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 1;

    const USER = 2;

    use HasFactory;

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
