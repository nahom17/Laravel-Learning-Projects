<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;

class AttributesController extends Controller
{

    public function index()
    {
        $attributes = Attribute::orderbyDesc('id')->paginate('30');
        return view('admin.attributes.index',compact('attributes'));
    }
    public function search(Request $request)
    {
        $search = $request->input('search');
        $attributes = Attribute::query()
        ->where('name', 'LIKE', "%" . $search . "%")
        ->paginate(20);
        return view('admin.attributes.index',compact('attributes'));
    }
    public function store(Request $request)
    {
        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();
        return redirect()->route('admin.attributes.index')->with('message', 'categorie toegevoged');
    }
    public function update(Request $request, Attribute $attribute)
    {
        $attribute->name = $request->name;
        $attribute->update();
        return redirect()->route('admin.attributes.index')->with('message', 'categorie bijgewerkt');
    }
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with('message', 'categorie verwijdered');
    }
}
