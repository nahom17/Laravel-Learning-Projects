@extends('layouts.app')
@section('content')
@php
$total = 0;
$total_vat = 0;
$total_price_excl = 0;
$total_discount = 0;
 //session()->forget('cart');
@endphp
    <div class="container">
        <div class="row flex-wrap">
            <div class="col-md-12">
        <div class="row align-items-center py-3">
            <div class="col-md-6">
                <h1>Winkelwagen</h1>
            </div>
        </div>
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>
                        {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif --}}
        @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
        @if (session('cart'))
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Prijs excl</th>
                        <th>Korting prijs excl</th>
                        <th>Aantal</th>
                        <th>Excl btw</th>
                        <th>Btw</th>
                        <th>Incl btw</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach (session('cart') as $product => $value)
                        @php

                                if($value['total']){
                                $total +=$value['total'] * $value["quantity"] * ($value["product"]->vat / 100) + $value['total'] * $value["quantity"];
                                $total_price_excl += $value['total'] * $value["quantity"];
                                $total_vat += $value['total'] * $value["quantity"] * ($value["product"]->vat / 100);
                                $total_discount += ($value["product"]->price * $value["quantity"]) - ($value['total'] * $value["quantity"]);

                                }else if ($value['product']->discount_price) {
                                $total += $value['product']->discount_price * $value["quantity"] * ($value["product"]->vat / 100) + $value['product']->discount_price * $value["quantity"];
                                $total_price_excl += $value['product']->discount_price * $value["quantity"];
                                $total_vat += $value['product']->discount_price * $value["quantity"] * ($value["product"]->vat / 100);
                                $total_discount += ($value["product"]->price * $value["quantity"]) - ($value['product']->discount_price * $value["quantity"]);
                                }
                                else
                                {
                                $total += $value["product"]->price * $value["quantity"] * ($value["product"]->vat / 100) + $value["product"]->price * $value["quantity"];
                                $total_price_excl += $value["product"]->price *$value["quantity"];
                                $total_vat += $value["product"]->discount_price ? ($value["product"]->discount_price) * $value["quantity"] * ($value["product"]->vat / 100) : ($value["product"]->price) * $value["quantity"] * ($value["product"]->vat / 100);
                                }

                                @endphp
                        <tr data-id="{{ $product }}">
                            <td data-th="Product">
                                <img style="width: 8%; height: " src="{{ asset('uploads/product/'.$value['product']->image) }}" alt="{{ $value['product']->image }}">
                                <p class="nomargin">{{ $value['product']->name }}</p>
                                @foreach($value['accessories'] as $accessory)
                            {{$accessory->name}} +&euro;{{number_format($accessory->discount_price, 2, ',', '.')}} <br>

                                @endforeach

                            </td>
                            @if($value['product']->discount_price)
                            <td style="text-decoration-line: line-through;">&euro;{{ number_format($value['product']->price, 2, ',', '.') }}</td>
                            {{-- <td>&euro;{{ number_format($value['product']->price, 2, ',', '.') }}</td> --}}
                            @endif
                            {{-- <td>&euro;{{ number_format($value['total'], 2, ',', '.') }}</td> --}}
                            <td>&euro;{{ number_format($value['product']->discount_price, 2, ',', '.') }}</td>
                            {{-- <td>&euro;{{ number_format($value['product']->price-$total_discount, 2, ',', '.') }}</td> --}}
                            <td data-th="Quantity">
                                <form action="{{ route('cart.update', $value['product']) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="totalPrice" value="{{$value['total']}}">
                                    <input type="number" onchange="this.form.submit()" name="quantity"
                                        value="{{ $value['quantity'] }}" class="form-control @error('quantity') is-invalid @else @enderror " min="1" />
                                        @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                                </form>
                            </td>
                            <td data-th="excl_vat" class="text-center">
                                @if($value['total'])
                                &euro;{{ number_format($value['total'] * $value['quantity'], 2, ',', '.') }}
                                @elseif($value['product']->discount_price)

                                &euro;{{ number_format($value['product']->discount_price * $value['quantity'], 2, ',', '.') }}
                                @else
                                &euro;{{ number_format($value['product']->price * $value['quantity'], 2, ',', '.') }}
                                @endif
                            </td>

                            <td data-th="vat" class="text-center">

                                {{ $value['product']->vat }}&percnt;
                            </td>
                            <td data-th="incl_vat" class="text-center">

                                @if($value['total'])
                                &euro;{{ number_format(($value['total'] * $value['quantity'])*$value['product']->vat/100+$value['total']*$value['quantity'], 2, ',', '.') }}
                                @elseif($value['product']->discount_price)

                                &euro;{{ number_format(($value['product']->discount_price * $value['quantity'])*$value['product']->vat/100+$value['product']->discount_price*$value['quantity'], 2, ',', '.') }}
                                @else
                                 &euro;{{ number_format(($value['product']->price * $value['quantity'] )*$value['product']->vat/100+$value['product']->price*$value['quantity'], 2, ',', '.') }}
                                @endif
                            </td>
                            <td class="actions" data-th="">
                                <form action="{{ route('cart.destroy', $value['product']) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="totalPrice" value="{{$value['total']}}">
                                    <button type="submit" onclick="return confirm('Weet u zeker dat u deze Product wilt verwijderen?');" class="btn btn-danger btn-sm float-end">X</button>
                                </form>
                            </td>
                            <td></td>
                        </tr>

                @endforeach
                </tbody>
            </table>
            </div>
            <div class="col-md-12">
            <div class="card">
            <div class="d-block text-end me-2 mt-2">
                @if($value['total'])
                <p>Korting: &euro;{{ number_format($total_discount, 2, ',', '.') }}</p>
                @elseif($value['product']->discount_price)
                <p>Korting: &euro;{{ number_format($total_discount, 2, ',', '.') }}</p>
                @endif
                <p>Exclusief btw : &euro; {{ number_format($total_price_excl, 2, ',', '.') }}</p>
                <p>Btw : &euro;{{ number_format($total_vat, 2, ',', '.') }}</p><hr>
                <p>Inclusief btw : &euro;{{ number_format($total , 2, ',', '.') }}</p><br><br><br>


            </div>
        </div>
        <div class="d-flex float-end mt-4">
            <a href="{{ route('cart.addCustomer') }}" class=" btn btn-primary  ms-2">Volgende</a>
                </div>
            </div>

            @else
            <div class="text-center align-items-center mt-5">
                    <span>Er zijn geen producten in jouw winkelwagen. </span><br>
                    <button class="btn btn-link rounded-1"><a  class="text-decoration-none text-center" href="{{ route('products.productIndex')}}">Verder winkelen</a></button>
                </div>
                <div class="float-end">

            </div>
        @endif
    @endsection

    </div>
