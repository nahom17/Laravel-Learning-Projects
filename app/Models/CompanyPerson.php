<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyPerson extends Model
{
    use HasFactory;
    protected $table = "companies_persons";
    protected $fillable = [
        'company_id',
        'person_id',
    ];


    public function Company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function Person() : BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
