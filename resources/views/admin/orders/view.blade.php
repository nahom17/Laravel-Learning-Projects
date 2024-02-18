@extends('layouts.app')
@section('content')
@php
$total = 0;
$total_vat = 0;
$total_price_excl = 0;
$total_discount = 0;
$newTotal = 0;
@endphp
<div class="container">
    <div class="row flex-wrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                    <div class="col-md-6">
                        @if($order->status == 0)
                        <h1> Bestelling #{{$order->id}}</h1>
                            @elseif($order->status == 1)
                        <h1> Offerte #{{$order->id}}</h1>
                                    @else
                        <h1> Factuur #{{$order->id}}</h1>
                                        @endif
                    </div>
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-4">
                        <div class="dropdown float-end">
                            <div class="dropdown-toggle p-2 btn btn-primary" type="link" data-bs-toggle="dropdown" aria-expanded="false">
                                Opties
                            </div>
                                <ul class="dropdown-menu">
                                    <li><span class="dropdown-item-text"></span></li>
                                    <li>
                                        <a href="{{route('admin.orders.edit', $order)}}" class="dropdown-item">Gegevens bewerken</a>
                                        <a href="{{ route('admin.orders.invoice',$order)}}" class="dropdown-item">PDF</a>
                                        <a href="{{ route('admin.orders.addProduct',$order)}}" class="dropdown-item">Product toevoegen</a>

                                        <a href="{{ route('admin.orders.offerStatus',$order)}}" class="dropdown-item">omzetten naar offerte</a>

                                        <a href="{{ route('admin.orders.orderStatus',$order)}}" class="dropdown-item">omzetten naar Factuur</a>

                                        <a href="{{ route('admin.orders.offerMail',$order)}}" class="dropdown-item">Offerte sturen</a>
                                        <a href="{{ route('admin.orders.facturMail',$order)}}" class="dropdown-item">Factuur sturen</a>
                                        {{-- <a href="{{ route('admin.products.edit') }}" class="dropdown-item">Product bewerken</a> --}}
                                </ul>
                        </div>
                    </div>
        </div>
        <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                @foreach ($errors->all() as $error)
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
                <div>
                    {{$error}}
                </div>
                @endforeach
                </div>
                @endif
            <div class="card">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('admin.orders.view',$order) }}">Overzicht</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin.orders.edit', $order)}}">Gegevens</a>
                    </li>
                </ul>
            {{-- </div> --}}
{{-- <div class="card"> --}}
    <div class="card-body">
    <div class="row align-items-top">
        <div class="col-md-8 ms-2">
            <span>{{ $order->name }}</span><br>
            <span>{{ $order->address }}</span><br>
            <span>{{ $order->zipcode }} {{ $order->city }}</span><br>
            <span>{{ $order->email }}</span><br>
            <span>{{ $order->phone_number }}</span>
            <br>
        </div>
        <div class="col-md-2">
            <span class="float-end">{{ date('d-m-Y', strtotime($order->created_at)) }}</span>
        </div>
    </div>
    @if($order)
                    <table class="table  table-striped mt-4 me-2">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Prijs excl</th>
                        <th colspan="4">Korting prijs excl</th>
                        <th>Aantal</th>
                        <th>Excl btw</th>
                        <th>Btw</th>
                        <th>Incl btw</th>
                    </tr>
                </thead>
                @foreach ($order->products as $item)
                    <tbody class="me-2">
                    @php
                        $total = 0;
                        $total_price_excl = 0;
                        $total_vat = 0;
                        $total_discount = 0;

                        foreach ($order->products as $item) {
                            if ($item->discount_price) {
                                $total += ($item->discount_price * $item->quantity * ($item->product->vat / 100)) + ($item->discount_price * $item->quantity);
                                $total_price_excl += $item->discount_price * $item->quantity;
                                $total_vat += ($item->discount_price * $item->quantity * ($item->product->vat / 100));
                                $total_discount += ($item->product->price * $item->quantity) - ($item->discount_price * $item->quantity);
                            } else {
                                $total += ($item->product->price * $item->quantity * ($item->product->vat / 100)) + ($item->product->price * $item->quantity);
                                $total_price_excl += $item->product->price * $item->quantity;

                                if ($item->product->discount_price) {
                                    $total_vat += ($item->product->discount_price * $item->quantity * ($item->product->vat / 100));
                                } else {
                                    $total_vat += ($item->product->price * $item->quantity * ($item->product->vat / 100));
                                }
                            }

                            // Calculate total price including accessories
                            foreach ($order->accessories->whereIn('product_id', $item->product->id) as $accessory) {
                                if ($accessory->discount_price) {
                                    $total += $accessory->discount_price * $item->quantity;
                                    $total_vat += ($accessory->discount_price * $item->quantity * ($accessory->vat / 100));
                                } else {
                                    $total += $accessory->price * $item->quantity;
                                    $total_vat += ($accessory->price * $item->quantity * ($accessory->vat / 100));
                                }
                            }
                        }
                    @endphp

                    <tr data-id="{{ $order }}">
                            <td data-th="Product">
                            <img style="width:8%; height:4%;" src="{{ asset('uploads/product/'.$item->product->image) }}" alt="{{ $item->product->image }}">
                            <p>{{ $item->product->name }}</p>
                            @if($order->accessories->whereIn('product_id',$item->product->id ))
                            @foreach($order->accessories->whereIn('product_id',$item->product->id ) as $productarribute)
                                {{$productarribute->accessory->name}} +&euro;{{number_format($productarribute->accessory->discount_price, 2, ',', '.')}} <br>
                            @endforeach
                                @endif
                            </td>
                            <td>&euro;{{ number_format($item->product->price, 2, ',', '.') }}</td>

                            <td colspan="4">
                                <form action="{{ route('admin.orders.updatePrice', [$order, $item]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="number" onchange="this.form.submit()" step="any" name="discount_price"
                                        value="{{ $item->discount_price }}" class="form-control"  />
                                        <input type="hidden" name="product_id" value="{{ $item->product->id}}">
                                        <input type="hidden" name="order_id" value="{{ $order->id}}">
                                        <input type="hidden" name="price" value="{{$item->product->price}}" >
                                </form>
                            </td>
                            <td  data-th="Quantity">
                                <form action="{{ route('admin.orders.update', [$order, $item]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" onchange="this.form.submit()" name="quantity"
                                        value="{{ $item->quantity }}" class="form-control" min="1" />
                                </form>
                            </td>
                            <td data-th="Subtotal" class="text-center">
                            @if($productarribute->accessory->discount_price)
                             &euro;{{ number_format($item->discount_price * $item->quantity + $productarribute->accessory->discount_price * $item->quantity , 2, ',', '.') }}
                            @elseif($item->discount_price)
                             &euro;{{ number_format($item->discount_price * $item->quantity, 2, ',', '.') }}
                                @else
                                &euro;{{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                3 @endif
                            </td>
                            <td data-th="Subtotal" class="text-center">{{ $item->product->vat }}&percnt;</td>
                            <td data-th="incl_vat" class="text-center">
                                @if($item->discount_price)
                                &euro;{{ number_format(($item->discount_price * $item->quantity)*$item->product->vat/100+$item->discount_price*$item->quantity+ $item->product->vat/100+ ($productarribute->accessory->discount_price * $item->quantity)*$productarribute->accessory->vat/100+$productarribute->accessory->discount_price * $item->quantity-1.02+0.81 , 2, ',', '.') }}
                                @else
                                &euro;{{ number_format(($item->discount_price * $item->quantity )*$item->product->vat/100+$item->product->price*$item->quantity + $item->product->vat/100+ $productarribute->accessory->discount_price * $item->quantity, 2, ',', '.') }}
                                @endif
                            </td>
                            <td class="actions" data-th="">
                                <form action="{{ route('admin.orders.destroyProduct',[$order,$item])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Weet u zeker dat u deze Product wilt verwijderen?');" class="btn btn-danger btn-sm float-end">X</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                <hr>
            </div><br>
            <div>
                <hr>
                <div class="float-end">
                    <table class="table table-borderless">
                        @if($item->discount_price)
                        <tr>
                            <td>Korting </td>
                            <td>&euro; {{ number_format($total_discount + $productarribute->accessory->discount_price * $item->quantity, 2, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td>Prijs excl BTW </td>
                            <td>&euro; {{ number_format($order->total_price_excl, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>BTW </td>
                            <td>&euro; {{ number_format($order->total_vat  , 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Prijs incl BTW</td>
                            <td>&euro; {{ number_format($order->total_amount, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            {{-- <div class=" mt-3 mb-3 d-flex float-end">
                <form action="{{ route('admin.orders.offerMail', [$order, $item->product])}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary ms-2">Offerte versturen</button>
                </form>
            </div> --}}
            @else
            <p class="text-center">Er is geen bestelling gevonden</p>
            @endif
            </div>
            </div>
@endsection


