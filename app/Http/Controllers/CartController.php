<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartStoreValidation;
use App\Http\Requests\CustomerStoreValidation;
use App\Models\Accessory;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        //$cartItems = session()->pull('cart');
        return view('cart.cart');
    }

    public function orderConfirmation()
    {
        return redirect()->route('products.productIndex');
    }

    public function show()
    {
        $cartItems = session()->get('cart');
        $customer = session()->get('customer');

        return view('cart.customerdetails', compact('cartItems', 'customer'));
    }

    public function addCustomer()
    {
        return view('cart.customer');
    }

    public function store(CustomerStoreValidation $request)
    {
        $customerData = [
            'name' => $request->name,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
        ];
        session()->put('customer', $customerData);
        session()->flash('message', 'Gegevenes  is toegevoegd in de bestelling overzicht');

        return redirect()->route('cart.show');
    }

    public function edit()
    {
        $customer = session()->get('customer');

        return view('cart.edit', compact('customer'));
    }

    public function create(CartStoreValidation $request, Product $product)
    {
        $cartItems = session()->get('cart', []);
        $totalPrice = $request->totalPrice;
        $quantity = 1;
        $accessories = collect(Accessory::get())->whereIn('id', collect(request()->accessories)->filter()->all());

        $cartItems[] = ['product' => $product, 'quantity' => $quantity, 'total' => $totalPrice, 'accessories' => $accessories];

        session()->pull('cart', []);
        session()->put('cart', $cartItems);
        session()->flash('message', 'Product is toegevoegd aan winkelwagen');

        return redirect()->route('cart.index');
    }

    public function update(CartStoreValidation $request, Product $product)
    {
        $cartItems = session()->get('cart', []);
        if ($cartItems) {
            foreach ($cartItems as $cartItem => $value) {
                $total = $request->totalPrice;
                if ($value['product']->is($product) && $value['total'] == $total) {
                    $cartItems[$cartItem] = ['product' => $product, 'quantity' => $request->quantity, 'total' => $request->totalPrice, 'accessories' => $value['accessories']];
                }
            }
        }
        session()->pull('cart', []);
        session()->put('cart', $cartItems);
        session()->flash('message', 'Het aantal is bijgewerkt in winkelwagen');

        return redirect()->route('cart.index');
    }

    public function destroy(Request $request, Product $product)
    {
        $cartItems = session()->get('cart');
        if ($cartItems) {
            foreach ($cartItems as $cartItem => $value) {
                $total = $request->totalPrice;
                if ($value['product']->is($product) && $value['total'] == $total) {
                    unset($cartItems[$cartItem]);
                }
            }
        }
        session()->pull('cart', []);
        session()->put('cart', $cartItems);
        session()->flash('message', 'Product is verwijderd uit de winkelwagen!');

        return redirect()->route('cart.index');
    }

    public function paymentSuccess()
    {
        return view('cart.paymentsuccess');
    }
}
