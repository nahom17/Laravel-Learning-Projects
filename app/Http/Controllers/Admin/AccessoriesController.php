<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessoriesStoreValidation;
use App\Models\Accessory;
use App\Models\Product;
use Attribute;
use GuzzleHttp\Handler\Proxy;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccessoriesController extends Controller
{
    public function index(Product $product): View
    {
        $accessories = Accessory::where('product_id', $product->id)->orderbyDesc('attribute_id')->paginate('30');
        return view ('admin.products.accessories.index',compact('accessories','product'));
    }

    public function create(Product $product): View
    {
        return view('admin.products.accessories.create',compact('product'));
    }

    public function search( Request $request, Product $product): View
    {
        $search = $request->input('search');
        $accessories = Accessory::orWhereRelation('product','name', 'LIKE', '%' . $request->search . '%')
        ->orWhereRelation('attribute','name', 'LIKE', '%' . $request->search . '%')
        ->orWhere('name', 'LIKE', '%' . $request->search . '%')
        ->paginate('30');

        return view('admin.products.accessories.index',compact('accessories'));
    }

    public function store(AccessoriesStoreValidation $request , Product $product, Attribute $attribute): RedirectResponse
    {
        $accessory = new Accessory();
        $accessory->attribute_id = $request->attribute_id;
        $accessory->product_id = $product->id;
        $accessory->name = $request->name;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/accessory/', $filename);
            $accessory->image = $filename;
        }
        $accessory->price = $request->price;
        $accessory->discount_price = $request->discount_price;
        $accessory->vat = $request->vat;
        $accessory->save();
        return redirect()->route('admin.products.accessories.index',$product)->with('message', 'accessory toegevoged');
    }
    public function edit(Product $product , Accessory $accessory) : View
    {
        return view('admin.products.accessories.edit',compact('accessory','product'));
    }
    public function update(Request $request, Product $product , Accessory $accessory) : RedirectResponse
    {
        $accessory->attribute_id = $request->attribute_id;
        $accessory->product_id = $product->id;
        $accessory->name = $request->name;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/accessory/', $filename);
            $accessory->image = $filename;
        }
        $accessory->price = $request->price;
        $accessory->discount_price = $request->discount_price;
        $accessory->vat = $request->vat;
        $accessory->save();
        return redirect()->route('admin.products.accessories.index',$product)->with('message', 'accessory bijgewerkt');
    }
    public function destroy(Product $product, Accessory $accessory):RedirectResponse
    {
        $accessory->delete();
        return redirect()->route('admin.products.accessories.index',$product)->with('message', 'accessory verwijdered');
    }
}
