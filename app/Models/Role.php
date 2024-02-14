<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
