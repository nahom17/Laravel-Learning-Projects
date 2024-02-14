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
                        <h1>Bedrijf toevoegen</h1>
                    </div>
        </div>
            <div class="card">
                {{-- @if ($errors->any())
        <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <div>
                {{$error}}
                </div>
                @endforeach
            </div>
            @endif --}}
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                        <form action="{{ route('admin.companies.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

            <div class="mb-3">
            <label for="">Naam</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" />
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
                </div>
                <div class="mb-3">
            <label for="">Adres</label>
            <input type="text" name="address" value="{{ old('address') }}"  class="form-control @error('address') is-invalid @enderror">
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Postcode</label>
            <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="form-control @error('zip_code') is-invalid @enderror">
            @error('zip_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Telefoonnummer</label>
            <input type="text" name="phone_number" value="{{ old('phone_number') }}"  class="form-control @error('phone_number') is-invalid @enderror">
            @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.companies.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Bedrijf toevoegen</button>
                    </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
