<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_User extends Model
{
    use HasFactory;

    protected $table = 'projects_users';

    protected $fillable = [
        'role_id',
        'user_id',
        'project_id',

    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
