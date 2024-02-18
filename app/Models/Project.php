<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [

        'title',
        'intro',
        'description',
        'image',
        'start_date',
        'end_date',

    ];

    public function users()
    {
        return $this->hasMany(Project_User::class, 'project_id');
    }

    public function Company()
    {
        return $this->belongsTo(Company::class);
    }
}
