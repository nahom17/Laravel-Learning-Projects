<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreValidation;
use App\Http\Requests\ProductUpdateValidation;
use App\Models\Accessory;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->paginate('30');

        return view('admin.products.index', compact('products'));
    }

    public function productIndex()
    {
        $products = Product::orderbyDesc('id')->paginate('30');

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $this->authorize('isAdmin', User::class);

        return view('admin.products.create');
    }

    public function search(Request $request)
    {

        $search = $request->input('search');
        $products = Product::query()
            ->where('name', 'LIKE', '%'.$search.'%')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function store(ProductStoreValidation $request)
    {
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/product/', $filename);
            $product->image = $filename;
        }
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->vat = $request->vat;
        $product->save();

        return redirect()->route('admin.products.index')->with('message', 'Product toegevoged');
    }

    public function show(Product $product, Attribute $attribute, Accessory $accessory)
    {
        $attribute = Attribute::orderby('name')->get();
        $accessories = Accessory::where('product_id', $product->id)->get();

        return view('products.show', compact('product', 'accessories', 'attribute'));
    }

    // public function total(Request $request,Product $product)
    // {
    //     $item = $request->accessory;
    //     $accessory = Accessory::where('id', $item)->first();
    //     $request->session()->put('accessory',$accessory);
    //     return redirect()->route('products.show',$product);

    // }

    public function edit(Product $product)
    {
        $this->authorize('isAdmin', User::class);

        return view('admin.products.edit', compact('product'));
    }

    public function update(ProductUpdateValidation $request, Product $product)
    {
        $product->name = $request->name;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
            $destination = 'uploads/product/'.$product->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move('uploads/product/', $filename);
            $product->image = $filename;
        }
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->vat = $request->vat;
        $product->update();

        return redirect()->route('admin.products.index')->with('message', 'Product bijgewerkt');
    }

    public function destroy(Product $product)
    {

        $destination = 'uploads/product/'.$product->image;
        if (File::exists($destination)) {
            File::delete($destination);
        }
        $product->delete();

        return redirect()->route('admin.products.index')->with('message', 'Product verwijdered');

    }
}
