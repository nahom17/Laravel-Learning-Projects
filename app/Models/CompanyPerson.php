<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPerson extends Model
{
    use HasFactory;

    protected $table = 'companies_persons';

    protected $fillable = [
        'company_id',
        'person_id',
    ];

    public function Company()
    {
        return $this->belongsTo(Company::class);
    }

    public function Person()
    {
        return $this->belongsTo(Person::class);
    }
}
