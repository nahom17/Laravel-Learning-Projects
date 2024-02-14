@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row flex-nowrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                <div class="col-md-6">
                    <h1>Gegevens bewerken</h1>
                </div>
                <div class="col-md-6">
                    <div class="dropdown float-end">
                            <div class="dropdown-toggle p-2 btn btn-primary" type="link" data-bs-toggle="dropdown" aria-expanded="false">
                                Opties
                            </div>
                                <ul class="dropdown-menu">
                                    <li><span class="dropdown-item-text"></span></li>
                                    <li>
                                        <a href="{{route('admin.orders.edit', $order)}}" class="dropdown-item">Gegevens bewerken</a>
                                        <a href="{{ route('admin.orders.invoice',$order)}}" class="dropdown-item" download>Bestelling pdf</a>
                                        <a href="{{ route('admin.orders.addProduct',$order)}}" class="dropdown-item">Product toevoegen</a>
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
        <ul class="nav nav-tabs mb-3">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route('admin.orders.view',$order) }}">Overzicht</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('admin.orders.edit', $order)}}">Gegevens</a>
            </li>
        </ul>
                <div class="card-body">
                    <form action="{{ route('admin.orders.address',$order) }}" method="post">
                        @csrf
                        @method('put')
                    <div class="row align-items-center py-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                        <label for="">Naam</label>
                        <input type="text" name="name" id=""
                            class="form-control @error('name') is-invalid @enderror" value="{{ $order->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Adres</label>
                        <input type="text" name="address" id="" class="form-control @error('address') is-invalid @enderror"
                            value="{{$order->address  }}">
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Postcode</label>
                        <input type="text" name="zip_code" id="" class="form-control @error('zip_code') is-invalid @enderror"
                            value="{{  $order->zip_code }}">
                        @error('zip_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                        <label for="">Plaats</label>
                        <input type="text" name="city" id="" class="form-control @error('city') is-invalid @enderror" value="{{ $order->city }}"
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
                            value="{{ $order->phone_number }}" >
                        @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Email</label>
                        <input type="email" name="email" id="" class="form-control @error('email') is-invalid @enderror"
                            value="{{ $order->email}}" >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                        </div>
                    </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.orders.view',$order)}}" class="nav-link me-2">Annuleren</a>
                        <button type="submit" class="btn btn-primary ms-2">Opslaan</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
