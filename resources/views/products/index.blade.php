@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row align-items-center py-3">
        <div class="col-md-4">
            <h1>Producten</h1>
        </div>
        <div class="col-md-4">

        </div>
        @if(Auth::check())
        <div class="col-md-4">
            {{-- <a href="{{ route('user.post.create') }}" class="btn btn-primary float-end">Artikel toevoegen</a> --}}
        </div>
        @endif
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
         @foreach ($errors->all() as $error)
         <div>
            {{$error}}
         </div>
         @endforeach
        </div>
        @endif
        @if (session()->has('status'))
            <div class="w-100 mt-4">
                <p class="mb-4 text-light bg-success rounded p-4">
                    {{ session()->get('status') }}
                </p>
            </div>
        @endif



    <div class="row align-items-start py-3">
        @if($products->isNotEmpty())
        @foreach ($products as $product)
        <div class="col-md-4 mb-5">
            <div class="card-group">
                    <div class="card">
            <a href="{{ route('products.show',$product) }}" class="nav nav-link mr-2"><img class="w-100" src="{{ asset('uploads/product/' .$product->image)}}" alt="{{$product->image}}"></a>
    <div class="card-body">
    <h5 class="card-title">{{$product->name }}</h5>
    <div class="row align-items-center">
        <div class="col-md-8">
            @if($product->discount_price)
            <p class="float-start me-2" style="text-decoration-line: line-through;">&euro;{{ number_format($product->price, 2,',','.')}}</p>
            <p class="text-danger"> NU &euro;{{ number_format($product->discount_price, 2,',','.')}} <small>Excl btw</small></p>
            @else
            <p class="float-start me-2">&euro;{{ number_format($product->price, 2,',','.')}} <small>Excl btw</small></p>
            @endif
        </div>
    </div>

        <a href="{{ route('products.show',$product) }}" class="text-decoration-none">Meer informatie</a>
    </div>
    </div>
            </div>

    </div>
    @endforeach
    </div>

<div class="mt-5">
    {{$products->links()}}
</div>
    @else
    <span class="text-center">Er is geen artikel gevonden</span>
</div>
    @endif
@endsection
