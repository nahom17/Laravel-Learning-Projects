<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyPerson;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CompanyPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Company $company) : View
    {
        $companiesPerson = CompanyPerson::all();
        return view('admin.company.person.index', compact('companiesPerson'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Company $company) : View
    {
        $companyPersons = CompanyPerson::where('company_id', $company->id)->get();
        $persons = Person::orderby('name')->get();
        foreach($companyPersons as $companyPerson) {
            $persons = $persons->where('id', '!=', $companyPerson->person_id);
        }
        return view('admin.company.person.index', compact('companyPersons'));
    }
}
