@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row align-items-center py-3">
        <div class="col-md-8">
            <h1>{{ $product->name }}</h1>
        </div>
        <div class="col-md-2">
        </div>
        @if(Auth::check())
        <div class="col-md-2">
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
        @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
        <div class="card">
            <div class="card-body">
                <form action="{{ route("cart.create",$product) }}" method="get">
                    @csrf
                <div class="row">
                    <div class="col-md-4 border-right">
                        <img class="w-100" src="{{ asset('uploads/product/'.$product->image) }}" alt="{{ $product->image }}">
                    </div>
                    <div class="col-md-6">
                        <h5 class="mb-0">Beschrijving</h5> <hr>
                        <p class="mt-3">{!! $product->description !!}</p>
                        @if($product->discount_price)
                        <label class="me-3" style="text-decoration-line: line-through;">&euro;{{ number_format($product->price, 2,',','.')}}</label><br>
                        <label class="me-3 text-danger" id="productPrice"> NU &euro;{{ number_format($product->discount_price , 2,',','.')}} <br><small>Excl btw</small></label>
                        @else
                        <label class="me-3">&euro;{{ number_format($product->price, 2,',','.')}} <small>Excl btw</small></label><br>
                        @endif
                        @foreach($product->accessories->unique('attribute_id') as $attributeValue)
                        <div class="row mt-3">
                            <div class="col-xs-2">
                                <p>{{$attributeValue->attribute->name}}</p>
                            </div>
                            <div class="col-md-10">
                                <select name="accessories[]" id="accessories"  onchange="myFunction({{ $product->accessories }})" class="form-control w-50">
                                    <option value="">Niets geselecteerd</option>
                                    @foreach($attributeValue->attribute->accessories->where('product_id', $product->id) as  $value)
                                        <option value="{{$value->id}}" name="{{$value->price}}">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $value->name }}</td>
                                {{-- <td>&euro; {{ number_format($value->price, 2, ',', '.') }}</td> --}}
                                +<td>&euro; {{ number_format($value->discount_price, 2, ',', '.') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                        <div class="col-md-4 mt-3">
                            <input type="hidden" name="quantity"    value="1" class="form-control text-center">
                            <input type="hidden" name="totalPrice" value="{{ $product->discount_price}}" class="form-control text-center">
                            <button type="submit" class="btn btn-primary me-3 float-start">In winkelwagen</button>
                        </div>
                    </div>

                </div>

                <div class="float-end">

                    <div class="row">
                        <div class="col-md-12 text-center">
                                totaal Prijs excl btw &euro; <span id="totalPrice" name="totalPrice"> {{ number_format($product->discount_price , 2,',','.')}}</span>
                        </div>
                    </div>

                    </div>
                    </form>

            </div>
        </div>
    </div>
    <script>
        const productPrice = {!! $product->discount_price !!}
        let total = productPrice;
        const accessories = document.querySelectorAll('[name="accessories[]"]');
        function myFunction(attributes){
            total = productPrice
            accessories.forEach(accessory => {
                attributes.forEach(e => {
                    if (accessory.value == e.id) {
                        total += e.discount_price
                    }
                })
            })
            document.querySelector('[name="totalPrice"]').value =  total;
            document.getElementById('totalPrice').innerHTML =  total;
        }

</script>
@endsection



