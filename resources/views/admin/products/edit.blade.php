@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row flex-nowrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">

                    <div class="col-md-8">
                        <h1>Product bewerken</h1>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin.products.accessories.create',$product) }}" class="btn btn-primary float-end">Configrator toevoegen</a>
                    </div>

        </div>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a  href="{{ route('admin.products.edit',$product->id) }}" class="nav-link active" id="nav-projects-tab">Info</a>
    <a href="{{ route('admin.products.accessories.index',$product->id) }}" class="nav-link" id="nav-profile-tab">Configuratie</a>
    </div>
            <div class="card">
        @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('admin.products.update',$product)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
            <div class="mb-3">
            <label for="">Naam</label>
            <input type="text" name="name" value="{{ $product->name }}" class="form-control  @error('name') is-invalid @else @enderror" />
            @error('name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Beschrijving</label>
            <textarea  id="description" name="description"     class="form-control @error('description') is-invalid @else @enderror">{{ $product->description }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Selecteer een bestand</label>
            <input type="file" name="image" value="{{ $product->image }}" class="form-control @error('image') is-invalid @else @enderror" />
            <img class="w-25" src="{{ asset('uploads/product/'.$product->image) }}" alt="{{ $product->image }}">
            @error('image')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Prijs</label>
            <input type="number" step="any" name="price" value="{{ $product->price }}" class="form-control  @error('price') is-invalid @else @enderror" />
            @error('price')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Korting prijs</label>
            <input type="number" step="any" name="discount_price" value="{{ $product->discount_price }}" class="form-control  @error('discount_price') is-invalid @else @enderror" />
            @error('discount_price')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Btw</label>
            <input type="text" name="vat" value="{{ $product->vat }}" class="form-control  @error('vat') is-invalid @else @enderror" />
            @error('vat')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
                    <div class="col mb-3">
                        <button type="submit" class="btn btn-primary float-end">Product opslaan</button><a href="{{ route('admin.products.index')}}" class="nav-link float-end">Annuleren</a>
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
