<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Mail\orderMail;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreValidation;
use App\Http\Requests\CustomerStoreValidation;
use App\Http\Requests\OrderPriceUpdateValidation;
use App\Http\Requests\OrderStoreValidation;
use App\Mail\offerMail;
use App\Mail\FacturMail;
use App\Models\Accessory;
use App\Models\Attribute;
use App\Models\OrderAccessory;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function index()
    {
        $this->authorize('isAdmin', User::class);
        $orders = Order::orderbyDesc('id')->paginate(70);
        return view('admin.orders.orders',compact('orders'));
    }

    public function createOrder( Product $products)
    {
        $this->authorize('isAdmin', User::class);
        $products = Product::orderBy('name')->get();
        return view('admin.orders.create', compact('products'));
    }
    public function show(Order $order )
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.orders.view',compact('order'));
    }
    public function invoice(Order $order)
    {
        $pdf = Pdf::loadView('pdf.invoice', ['order' => $order]);
        return $pdf->stream('invoice.pdf');
    }
    public function destroy(Order $order)
    {
        $this->authorize('isAdmin', User::class);
        $order->delete();
        return redirect()->route('admin.orders.index', 'order')->with('message', 'Bestelling verwijdred');
    }
    public function search(Request $request)
    {
        $search = $request->input('search');
        $orders = Order::query()
        ->where('name', 'LIKE', "%" . $search . "%")
        ->orWhere('id', 'LIKE', "%" . $search . "%")
        ->paginate(20);
        return view('admin.orders.orders',compact('orders'));
    }
    public function storeOrder(OrderStoreValidation $request , Order $order , OrderProduct $orderProduct, Product $product)
    {
        $total_amount = 0;
        $discount_price  = 0;
        $total_vat = 0;
        $total_excl_price =0;
        $price_excl = 0;

        $products = Product::findOrFail($request->product_id);
        $total_amount += ($products->discount_price * ( $products->vat/100)) + $products->discount_price;
//dd($products->discount_price * $products->vat/100 + $products->discount_price);
        $price_excl += $products->discount_price;
        $total_vat += $discount_price * $products->vat;

        $order = new Order;
        $order->name = $request->name;
        $order->address = $request->address;
        $order->zip_code = $request->zip_code;
        $order->city = $request->city;
        $order->email = $request->email;
        $order->phone_number= $request->phone_number;
        $order->total_amount = ($products->discount_price * ( $products->vat/100)) + $products->discount_price;
        $order->total_vat = $total_vat;
        $order->total_price_excl = $total_amount;
        $order->status = 0 ;

        $order->save();
        $products = new OrderProduct();
        $products->order_id = $order->id;
        $products->product_id = $request->product_id;
        $products->quantity = 1 ;
        $products->price_excl = $products->product->price;
        $products->discount_price = $products->product->discount_price;
       // dd($products->product->discount_price);
        $products->vat = $products->product->vat;
        $products->save();
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'Bestelling toevoeged');
    }

    public function offerMail(Order $order, OrderProduct $orderProduct)
    {
        Mail::to('nahomtes@nahomtesfamichael.nl')->send(new offerMail($order,$orderProduct));
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'offerte verstruud');
    }

    public function offerStatus(Order $order)
    {
        $order->status = 1;
        $order->save();
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'status is bijgewerkt');
    }

    public function orderStatus(Order $order)
    {
        $order->status = 2;
        $order->save();
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'status is bijgewerkt');
    }
    public function facturMail(Order $order , OrderProduct $orderProduct)
    {
        Mail::to('nahomtes@nahomtesfamichael.nl')->send(new FacturMail($order,$orderProduct));
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'Factuur verstruud');
    }

    public function store(Request $request)
    {
        $total = 0;
        $total_vat = 0;
        $total_price_excl = 0;
        $total_discount = 0;
        $cartItems = session()->get('cart',[]);
        $customer = session()->get('customer', []);

        foreach( $cartItems  as $cartItem ){
                if($cartItem['total'])
                {
                $total +=$cartItem['total'] * $cartItem["quantity"] * ($cartItem["product"]->vat / 100) + $cartItem['total'] * $cartItem["quantity"];
                $total_price_excl += $cartItem['total'] * $cartItem["quantity"];
                $total_vat += $cartItem['total'] * $cartItem["quantity"] * ($cartItem["product"]->vat / 100);
                $total_discount += ($cartItem["product"]->price * $cartItem["quantity"]) - ($cartItem['total'] * $cartItem["quantity"]);
                }
                else if ($cartItem['product']->discount_price)
                {
                $total += $cartItem['product']->discount_price * $cartItem["quantity"] * ($cartItem["product"]->vat / 100) + $cartItem['product']->discount_price * $cartItem["quantity"];
                $total_price_excl += $cartItem['product']->discount_price * $cartItem["quantity"];
                $total_vat += $cartItem['product']->discount_price * $cartItem["quantity"] * ($cartItem["product"]->vat / 100);
                $total_discount += ($cartItem["product"]->price * $cartItem["quantity"]) - ($cartItem['product']->discount_price * $cartItem["quantity"]);
                }
                else
                {
                $total += $cartItem["product"]->price * $cartItem["quantity"] * ($cartItem["product"]->vat / 100) + $cartItem["product"]->price * $cartItem["quantity"];
                $total_price_excl += $cartItem["product"]->price * $cartItem["quantity"];
                $total_vat += $cartItem["product"]->price * $cartItem["quantity"] * ($cartItem["product"]->vat / 100);
                }
        //$discount_price += $cartItem['product']->price - $cartItem['discount_price'];
        }
        $order = new Order;
        $order->name = $customer['name'];
        $order->address = $customer['address'];
        $order->zip_code = $customer['zip_code'];
        $order->city = $customer['city'];
        $order->email = $customer['email'];
        $order->phone_number = $customer['phone_number'];
        $order->total_amount = $total;
        $order->total_vat = $total_vat;
        $order->total_price_excl = $total_price_excl;
        $order->status = 0;
        $order->save();

        foreach( $cartItems  as $cartItem ){
        $orderProduct = new OrderProduct();
        $orderProduct->order_id = $order->id;
        $orderProduct->product_id = $cartItem['product']->id;
        $orderProduct->quantity = $cartItem['quantity'];
        $orderProduct->price_excl =$cartItem['product']->price;
        $orderProduct->discount_price = $cartItem['product']->discount_price;
        $orderProduct->vat = $cartItem['product']->vat;
        $orderProduct->save();

        $orderAccessory = new OrderAccessory();
        $orderAccessory->order_id = $order->id;
        foreach($cartItem['accessories'] as $accessory){
        $orderAccessory->product_id = $accessory->product_id;
        $orderAccessory->accessory_id = $accessory->id;
        $orderAccessory->accessory_name = $accessory->name;
        $orderAccessory->price = $accessory->price;
        $orderAccessory->discount_price = $accessory->discount_price;
        $orderAccessory->vat = $accessory->vat;
        $orderAccessory->save();
        }
        }

        $products = OrderProduct::where('order_id', $order->id)->get();
        Mail::to('nahomtes@nahomtesfamichael.nl')->send(new orderMail($order, $products));
        $request->session()->forget(['cart','customer']);
        return redirect()->route('cart.index')->with('message', 'Bedankt! Uw bestelling is geplaatst.');
    }

    public function update(Order $order,OrderProduct $orderProduct, CartStoreValidation $request)
    {
        $this->authorize('isAdmin', User::class);
        $orderProduct->quantity = $request->quantity;
        $orderProduct->save();
        $this->calculator($order);
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'Het aantal is bijgewerkt');
    }

    public function updatePrice(Order $order,OrderProduct $orderProduct, OrderPriceUpdateValidation $request)
    {

        $this->authorize('isAdmin', User::class);
        $orderProduct->discount_price = $request->discount_price;
        $orderProduct->save();
        $this->calculator($order,$orderProduct);
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'Het prijs is bijgewerkt');
    }
    public function edit(Order $order, OrderAccessory $orderAccessory)
    {    $this->authorize('isAdmin', User::class);
        return view('admin.orders.edit', compact('order','orderAccessory'));
    }

    public function addProduct(Product $products , Order $order ,Attribute $attribute , Accessory $accessory)
    {    $this->authorize('isAdmin', User::class);
        $attributes = Attribute::orderBy('name')->get();
        $accessories = Accessory::where('product_id' ,$products->id, 'attribute_id' , $attribute->id)->first();
        $orderProducts = OrderProduct::where('order_id', $order->id)->get();
        $products = Product::orderBy('name')->with('accessories')->with('accessories.attribute')->get();
        foreach($orderProducts as $orderProduct){
            $products = $products->where('id', '!=', $orderProduct->product_id);
        }

        return view('admin.orders.product.create', compact('products', 'order','accessories','attribute'));
    }

    public function storeProduct(Request $request,Order $order)
    {   $total = 0;
        $total_vat = 0;
        $total_price_excl = 0;
        $total_discount = 0;

        $this->authorize('isAdmin', User::class);
        $product = Product::findOrFail($request->product_id);
        $orderProducts =  new OrderProduct();
        $orderProducts->product_id = $request->product_id;
        $orderProducts->order_id = $order->id;
        $orderProducts->quantity = 1;
        $orderProducts->price_excl = $orderProducts->product->price;
        $orderProducts->discount_price = $orderProducts->product->discount_price;
        $orderProducts->vat = $orderProducts->product->vat;
        $orderProducts->save();
        return redirect(route('admin.orders.view',compact('order')))->with('message', 'Product toegevoged');
    }
    public function address(Order $order,OrderProduct $orderProduct, CustomerStoreValidation $request )
    {
        $this->authorize('isAdmin', User::class);
        $order->name = $request->name;
        $order->address = $request->address;
        $order->zip_code = $request->zip_code;
        $order->city = $request->city;
        $order->email = $request->email;
        $order->phone_number = $request->phone_number;
        $order->update();
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'gegevenes bijgewerkt');;
    }
    public function destroyProduct(Order $order, OrderProduct $orderProduct)
    {
    $this->authorize('isAdmin', User::class);
    $orderProduct->delete();
    $orderProducts = OrderProduct::where('order_id', $order->id)->get();
    if (count($orderProducts) == 0) {
        $order->delete();
        return redirect(route('admin.orders.index'))->with('message', 'Bestelling is verwijderd omdat het laatste product is verwijderd');
    }
    $this->calculator($order);
    $order->save();
        return redirect(route('admin.orders.view', compact('order')))->with('message', 'Product verwijdered');
    }

    private function calculator(Order $order)
    {
        $total_price_excl = 0;
        $total_vat = 0;
        $orderProducts = OrderProduct::where('order_id' , $order->id)->get();
        $orderAccessories = OrderAccessory::where('order_id', $order->id)->get();



        foreach($orderProducts as $orderProduct)
        {
            foreach($orderAccessories as $orderAccessory){
                if($orderAccessory->accessory->discount_price){
                    $total_price_excl += $orderAccessory->accessory->discount_price * $orderProduct->quantity;
                    $total_vat += $orderAccessory->accessory->discount_price * $orderProduct->quantity * ($orderProduct->vat/100);
                }else{
                    $total_price_excl += $orderProduct->quantity;
                    $total_vat += $orderProduct->price + $orderAccessory->accessory->price * $orderProduct->quantity * ($orderProduct->vat/100);

                }
            }
            if($orderProduct->discount_price){
                $total_price_excl += $orderProduct->discount_price * $orderProduct->quantity;
                $total_vat += $orderProduct->discount_price   * $orderProduct->quantity * ($orderProduct->vat/100);
            } else{
                $total_price_excl += $orderProduct->price_excl  + $orderAccessory->accessory->discount_price * $orderProduct->quantity;
                 $total_vat += $orderProduct->price_excl  * $orderProduct->quantity * ($orderProduct->vat/100);
            }
        }
        $total_amount = $total_price_excl + $total_vat;
        $order->total_amount = $total_amount;
        $order->total_price_excl = $total_price_excl;
        $order->total_vat = $total_vat;
        $order->save();
    }





}
