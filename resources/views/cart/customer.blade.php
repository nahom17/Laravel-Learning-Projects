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
            <div class="col-md-8">
                <div class="row align-items-center py-3">
                    <div class="col-md-4">
                        <h1>Bezorggegevens</h1>
                    </div>
                    <div class="col-md-4">
                        {{-- zoek functie --}}
                    </div>
                    <div class="col-md-4">
                        <a href=""></a>
                    </div>
                </div>
                <form action="{{ route('cart.storeCustomer') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="">Naam</label>
                        <input type="text" name="name" id=""
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Adres</label>
                        <input type="text" name="address" id="" class="form-control @error('address') is-invalid @enderror"
                            value="{{ old('address') }}">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Postcode</label>
                        <input type="text" name="zip_code" id="" class="form-control @error('zip_code') is-invalid @enderror"
                            value="{{ old('zip_code') }}">
                        @error('zip_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Plaats</label>
                        <input type="text" name="city" id="" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}"
                            >
                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Telefoonnummer</label>
                        <input type="tel" name="phone_number" id="" class="form-control @error('phone_number') is-invalid @enderror"
                            value="{{ old('phone_number') }}" >
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="email" name="email" id="" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 float-end">
                        <button type="submit" class="btn btn-primary float-end ms-2">Volgende</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 mt-5">
                <div class="card mt-5">
                    <div class="card-body">
                        @if (session('cart'))
                        <table class="table  table-striped mt-4">
                            <thead>
                                <tr>
                                    <th class="text-center">Samenvatting van uw bestellingen</th>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3 d-block text-end">
                            @if($value['total'])
                            <p>Korting: &euro;{{ number_format($total_discount, 2, ',', '.') }}</p>
                            @elseif($value['product']->discount_price)
                            <p>Korting: &euro;{{ number_format($total_discount, 2, ',', '.') }}</p>
                            @endif
                            <p>Exclusief btw : &euro; {{ number_format($total_price_excl, 2, ',', '.') }}</p>
                <p>Btw : &euro;{{ number_format($total_vat, 2, ',', '.') }}</p><hr>
                <p>Inclusief btw : &euro;{{ number_format($total , 2, ',', '.') }}</p>

                        </div><br>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
