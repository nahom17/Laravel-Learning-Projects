@extends('layouts.app')
@section('content')
@php
$total_amount = 0;
$total_vat = 0;
$total_excl_price =0;
@endphp
<div class="container">
    <div class="row flex-nowrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                <div class="card-header">
                    <h1>Bestelling toevoegen</h1>
                </div>
        </div>
            <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('admin.orders.storeOrder')}}" method="post">
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
                    <div class="mb-3">
                        <label for="">product</label>
                        <select name="product_id" class="form-control" id="select2">
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.orders.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary float-end">Bestelling toevoegen</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
