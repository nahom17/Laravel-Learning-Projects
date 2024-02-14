<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;
    protected $table = "Articles";
    protected $fillable = [

        'title',
        'intro',
        'description',
        'image',
        'start_date',
        'end_date',
 ];

}
