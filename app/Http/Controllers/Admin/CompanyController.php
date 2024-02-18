<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreValidation;
use App\Models\Company;
use App\Models\CompanyPerson;
use App\Models\Person;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderByDesc('id')->paginate(30);

        return view('admin.company.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.company.create');
    }

    public function store(CompanyStoreValidation $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->address = $request->address;
        $company->zip_code = $request->zip_code;
        $company->phone_number = $request->phone_number;
        $company->email = $request->email;
        $company->save();

        return redirect()->route(('admin.companies.index'))->with('message', 'Bedrijf toegevoegd');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $companies = Company::query()
            ->where('name', 'LIKE', '%'.$search.'%')
            ->ORwhere('email', 'LIKE', '%'.$search.'%')
            ->paginate(30);

        return view('admin.company.index', compact('companies'));
    }

    public function edit(Company $company)
    {
        $companyPersons = CompanyPerson::where('company_id', $company->id)->get();
        $persons = Person::orderBy('name')->get();
        foreach ($companyPersons as $companyPerson) {
            $persons = $persons->where('id', '!=', $companyPerson->person_id);
        }

        return view('admin.company.edit', compact('persons', 'company'));
    }

    public function update(CompanyStoreValidation $request, Company $company)
    {
        $company->name = $request->name;
        $company->address = $request->address;
        $company->zip_code = $request->zip_code;
        $company->phone_number = $request->phone_number;
        $company->email = $request->email;
        $company->update();

        return redirect()->route('admin.companies.index')->with('message', 'Bedrijf bijgewerkt');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin.companies.index')->with('message', 'Bedrijf verwijdered');
    }
}
