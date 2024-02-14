@extends('layouts.app')
@section('content')
@php
$price_excl = 0;
@endphp
<div class="container">
    <div class="row flex-nowrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                <div class="card-header">
                    <h1>Product toevoegen</h1>
                </div>
        </div>
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('admin.orders.storeProduct',$order)}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="">product</label>
                        <select id="select2" name="product_id" class="form-control js-example-basic-single" {{ count($products) == 0 ? 'disabled' : '' }}>
                            @forelse ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}
                            </option>
                            @empty
                            <option>Er zijn geen producten meer die je kan toevoegen</option>
                            @endforelse
                            <option></option>

                        </select>
                            </div>
                            <div id="attributes">
                                @foreach($product->accessories->unique('attribute_id') as $attributeValue)
                                    <div class="row mt-3">
                                        <div class="col-xs-2">
                                            <p>{{$attributeValue->attribute->name}}</p>
                                        </div>
                                        <div class="col-md-10">
                                            <select name="accessories[]" id="accessories" class="form-control w-50">
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
                            </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.orders.view',$order)}}" class="nav-link me-2">Annuleren</a>
                        <button type="submit" class="btn btn-primary float-end {{ count($products) == 0 ? 'disabled' : '' }}">Product toevoegen</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <script>
        const attributes = document.querySelector('#attributes');

        $('#select2').on('select2:select', function (event) {
            attributes.innerText = '';
            var id = event.target.value

            if(id !== '') {
                const products = Object.entries({!! $products !!})

                let product = products.filter(([x, y]) => y.id == id)[0][1]

                product.accessories.forEach((accessory) => {

                    if(accessory.attribute.accessories) {
                        let createDiv = document.createElement('div');
                        createDiv.classList.add('row', 'mt-3');

                        let createSelect = document.createElement('select');
                        createSelect.classList.add('form-select');
                        let label = document.createElement('label');
                        createSelect.classList.add('form-label');

                        label.innerText = accessory.attribute.name;

                        accessory.attribute.accessories.forEach((accessory1) => {
                            var newOption = new Option(accessory1.name,accessory1.id, false, false);
                            createSelect.append(newOption);

                        })

                        createDiv.append(label);
                        createDiv.append(createSelect);
                        $('#attributes').append(createDiv);
                    }
                })

                for(attribute in product.accessories) {
                    console.log(product.accessories[attribute], attribute)
                    var newOption = new Option(data['id'],data['name'], false, false);
                    $('#select2').append(newOption).trigger('change');
                }
            }

            var newOption = new Option('Niets geselectreerd','', false, false);
            $('#select2').append(newOption).trigger('change');


            var data = products[event.target.value]

            console.log(data)


        })



    </script>
</div>
@endsection
