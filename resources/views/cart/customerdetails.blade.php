@extends('layouts.app')
@section('content')
@php
$total = 0;
$total_vat = 0;
$total_price_excl = 0;
$total_discount = 0;
@endphp
<div class="container">
    <div class="row flex-wrap">
        <div class="col-md-12">
        <div class="row align-items-center py-3">
            @if (session('cart'))
                    <div class="col-md-6">
                        <h1>Bestelling overzicht</h1>
                    </div>
                    <div class="col-md-2">
                        {{-- zoek functie --}}
                    </div>
                    <div class="col-md-4">
                    </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
            <div class="row align-items-top">
                @if (session('customer'))
                <div class="col-md-4">
                    <span>{{ $customer['name'] }}</span><br>
                    <span>{{ $customer['address'] }}</span><br>
                    <span>{{ $customer['zip_code'] }} {{ $customer['city'] }}</span><br>
                    <span>{{ $customer['phone_number'] }}</span><br>
                    <span>{{ $customer['email'] }}</span><br>
                    <form action="{{ route("cart.edit") }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link text-decoration-none p-0 float-start">Gegevens bewerken</button>
                    </form>
                </div>
                @endif

            </div>

            <table class="table  table-striped mt-4">
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
                @foreach (session('cart') as $product => $value)
                    <tbody>
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
                                <p class="nomargin">{{ $value['product']->name }}</p>
                                @foreach($value['accessories'] as $accessory)
                            {{$accessory->name}} +&euro;{{$accessory->discount_price}} <br>

                                @endforeach
                            </td>
                            @if($value['product']->discount_price)
                            <td style="text-decoration-line: line-through;">&euro;{{ number_format($value['product']->price, 2, ',', '.') }}</td>
                            @else
                            <td>&euro;{{ number_format($value['product']->price, 2, ',', '.') }}</td>
                            @endif
                            <td>&euro;{{ number_format($value['product']->discount_price, 2, ',', '.') }}</td>
                            <td data-th="Quantity">
                                        {{ $value['quantity'] }}
                            </td>
                            <td>@if($value['total'])
                                &euro;{{ number_format($value['total'] * $value['quantity'], 2, ',', '.') }}
                                @elseif($value['product']->discount_price)

                                &euro;{{ number_format($value['product']->discount_price * $value['quantity'], 2, ',', '.') }}
                                @else
                                &euro;{{ number_format($value['product']->price * $value['quantity'], 2, ',', '.') }}
                                @endif
                                </td>
                            <td data-th="Subtotal" class="text-center">{{ $value['product']->vat }}&percnt;</td>
                            <td data-th="incl_vat" class="text-center">
                                @if($value['total'])
                                &euro;{{ number_format(($value['total'] * $value['quantity'])*$value['product']->vat/100+$value['total']*$value['quantity'], 2, ',', '.') }}
                                @elseif($value['product']->discount_price)

                                &euro;{{ number_format(($value['product']->discount_price * $value['quantity'])*$value['product']->vat/100+$value['product']->discount_price*$value['quantity'], 2, ',', '.') }}
                                @else
                                 &euro;{{ number_format(($value['product']->price * $value['quantity'] )*$value['product']->vat/100+$value['product']->price*$value['quantity'], 2, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
            </div>
            <div class="mb-3 d-block text-end">
                <div class="card">
                    <div class="card-body">
                        @if($value['product']->discount_price)
                <p>Korting: &euro;{{ number_format($total_discount, 2, ',', '.') }}</p>
                @endif
                <p>Exclusief btw : &euro; {{ number_format($total_price_excl, 2, ',', '.') }}</p>
                <p>Btw : &euro;{{ number_format($total_vat, 2, ',', '.') }}</p><hr>
                <p>Inclusief btw : &euro;{{ number_format($total , 2, ',', '.') }}</p></p>
                    </div>
                </div>
                <div class=" mt-4 mb-3 d-flex float-end">
                    <a href="{{ route("cart.index") }}" class="text-decoration-none text-secondary me-3">Wijzigen winkelwagen</a>
                    <div id="paypal-button-container">
                    </div>
            </div>
            </div>
            @else<br>
            <div>
                <p class="text-center">Er is geen bestelling gevonden</p>
            </div>
        @endif
        </div>
    </div>

<script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}&currency=EUR&disable-funding=credit,card,ideal,sofort"></script>
    <script>
    paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
        return actions.order.create({
            purchase_units: [{
            amount: {
                value:  '{!! number_format($total , 2, '.','') !!}' // Can also reference a variable or function
            }
            }]
        });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
        return fetch("<?= route('order.store')?>",
        {
            method: "post",
            headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    }
        })
        .then(function(paymentSuccess) {
            window.location.href = "<?= route('cart.paymentSuccess') ?>";
            });
        }
    }).render('#paypal-button-container');
    </script>
@endsection


