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
                    <h1>Product toevoegen</h1>
                </div>
        </div>

            <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('admin.products.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
            <div class="mb-3">
            <label for="name">Naam</label>
            <input type="text" name="name" value="{{ name }}" class="form-control  @error('name') is-invalid @else @enderror" />
            @error('name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="description">Beschrijving</label>
            <textarea  id="description" name="description"     class="form-control @error('description') is-invalid @else @enderror">{{ old('description') }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Selecteer een bestand</label>
            <input type="file" name="image" value="{{ old('image') }}" class="form-control @error('image') is-invalid @else @enderror" />
            @error('image')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Prijs</label>
            <input type="number" step="any" name="price" value="{{ old('price') }}" class="form-control  @error('price') is-invalid @else @enderror" />
            @error('price')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Korting prijs</label>
            <input type="number" step="any" name="discount_price" value="{{ old('discount_price') }}" class="form-control  @error('discount_price') is-invalid @else @enderror" />
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
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.products.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Product toevoegen</button>
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
