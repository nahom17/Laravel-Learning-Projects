<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyStoreValidation;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{

    public function index()
    {
        $persons = Person::orderByDesc('id')->paginate(30);
        return view('admin.person.index',compact('persons'));
    }


    public function create()
    {
        return view('admin.person.create');
    }

    public function store(CompanyStoreValidation $request)
    {
        $person = new Person;
        $person->name = $request->name;
        $person->address = $request->address;
        $person->zip_code = $request->zip_code;
        $person->phone_number = $request->phone_number;
        $person->email = $request->email;
        $person->save();
        return redirect()->route(('admin.persons.index'))->with('message', 'Persoon toegevoegd');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Get the search value from the request
        $search = $request->input('search');

        // Search in the title and body columns from the posts table
        $persons = Person::query()
            ->where('name', 'LIKE', "%" . $search . "%")
            ->ORwhere('email', 'LIKE', "%" . $search . "%")
            ->paginate(30);
        // Return the search view with the resluts compacted
        return view('admin.person.index',compact('persons'));
    }


    public function edit(Person $person)
    {
        return view('admin.person.edit',compact('person'));
    }


    public function update(CompanyStoreValidation $request, Person $person)
    {
        $person->name = $request->name;
        $person->address = $request->address;
        $person->zip_code = $request->zip_code;
        $person->phone_number = $request->phone_number;
        $person->email = $request->email;
        $person->save();
        return redirect()->route(('admin.persons.index'))->with('message', 'Persoon bijgewerkt');
    }


    public function destroy(Person $person)
    {
        $person->delete();
        return redirect()->route(('admin.persons.index'))->with('message', 'Persoon verwijdered');
    }
}
