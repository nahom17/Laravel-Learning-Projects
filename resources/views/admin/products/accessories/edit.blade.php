@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row flex-nowrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                <div class="card-header">
                    <h1>Configrator toevoegen</h1>
                </div>
        </div>
            <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a  href="{{ route('admin.products.edit',$product->id) }}" class="nav-link" id="nav-projects-tab">Info</a>
    <a href="{{ route('admin.products.accessories.index',$product->id) }}" class="nav-link active" id="nav-profile-tab">Configuratie</a>
    </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.accessories.update',[$product,$accessory])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    
            <div class="mb-3">
            <label for="name">Naam</label>
            <input type="text" name="name" value="{{ $accessory->name }}" class="form-control  @error('name') is-invalid @else @enderror" />
            @error('name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Selecteer een bestand</label>
            <input type="file" name="image" value="{{ $accessory->image }}" class="form-control @error('image') is-invalid @else @enderror" />
            <img class="w-25" src="{{ asset('uploads/accessory/'.$accessory->image) }}" alt="{{ $accessory->image }}">
            @error('image')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Prijs</label>
            <input type="number" step="any" name="price" value="{{ $accessory->price }}" class="form-control  @error('price') is-invalid @else @enderror" />
            @error('price')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Korting prijs</label>
            <input type="number" step="any" name="discount_price" value="{{ $accessory->discount_price }}" class="form-control  @error('discount_price') is-invalid @else @enderror" />
            @error('discount_price')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Btw</label>
            <input type="text" name="vat" value="21" class="form-control  @error('vat') is-invalid @else @enderror" />
            @error('vat')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
                    <label for="">Categorie</label>
                    <select class="form-select @error('attribute_id') is-invalid @else @enderror" name="attribute_id" id="select1">
                        @php
                        $attributes = App\Models\ Attribute::all();
                        @endphp
                        @foreach ( $attributes as $attribute )
                        <option value="{{ $attribute->id}}">{{ $attribute->name}}</option>
                        @endforeach
                    </select>
                    @error('attribute_id')
                        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
                    </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.products.accessories.index',$product)}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Configrator opslaan</button>
                    </div>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.log(error);
            });
    </script>
@endsection
