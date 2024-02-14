<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project_User extends Model
{
    use HasFactory;
    protected $table = 'projects_users';
    protected $fillable = [
        'role_id',
        'user_id',
        'project_id'

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
