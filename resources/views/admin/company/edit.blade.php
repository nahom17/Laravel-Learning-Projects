@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row flex-nowrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                    <div class="col-md-4">
                        <h1>Bedrijf bewerken</h1>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                <nav>
        <div class="dropdown  float-end">
<div class="dropdown-toggle p-2 btn btn-primary" type="link" data-bs-toggle="dropdown" aria-expanded="false">
Opties
</div>
<ul class="dropdown-menu">

    <li><span class="dropdown-item-text"></span></li>
    <li>
<button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#addpersoncompany{{ $company->id }}">
Persoon koppelen
</button>
<button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createpersoncompany">
Persoon toevoegen
</button>
</ul>
</div>
</nav>
        </div>
        </div>
        <div class="modal fade" id="addpersoncompany{{ $company->id}}" tabindex="-1" aria-labelledby="addpersoncompanyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addpersoncompanyModalLabel">Persoon toevoegen </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mt-4">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                <div>
                            {{ $error }}
                        </div>
                    @endforeach

                </div>
            @endif
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
            @endif
            <div class="card-body">
                <form action="{{ route('admin.companies.persons.store',$company->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="">Naam</label>
                        <select name="person_id" id="small-select2-options-single-field" class="form-control">
                            @foreach ($persons as $person)
                            <option value="{{ $person->id }}">{{ $person->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col mb-3">
                        <button type="submit" class="btn btn-primary float-end">Persoon Koppelen</button><a
                        href="{{ route('admin.companies.index',)}}" class="nav-link float-end">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="createpersoncompany" tabindex="-1" aria-labelledby="createpersoncompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createpersoncompanyModalLabel">Persoon toevoegen </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card mt-4">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                        <div>
                            {{ $error }}
                        </div>
                        @endforeach

                    </div>
                    @endif
                    @if (session('message'))
                    <div class="alert alert-success text-center"> {{ session('message') }}
                        <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
                    </div>
                    @endif
                    <div class="card-body">
                        <form action="{{ route('admin.companies.persons.store',$company )}}" method="POST" enctype="multipart/form-data">
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
                        <a href="{{ route('admin.companies.persons.index', ['company' => $company]) }}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Persoon toevoegen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a  href="{{ route('admin.companies.edit',$company->id) }}" class="nav-link active" id="nav-projects-tab">Info</a>
    <a href="{{ route('admin.companies.persons.index',$company->id) }}" class="nav-link" id="nav-profile-tab">Personen</a>
</div>
<div class="card">
     @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                        <form action="{{ route('admin.companies.update',$company)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

            <div class="mb-3">
            <label for="">Naam</label>
            <input type="text" name="name" value="{{ $company->name }}" class="form-control @error('name') is-invalid @enderror" />
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
                </div>
                <div class="mb-3">
            <label for="">Adres</label>
            <input type="text" name="address" value="{{ $company->address }}"  class="form-control @error('address') is-invalid @enderror">
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Postcode</label>
            <input type="text" name="zip_code" value="{{ $company->zip_code }}" class="form-control @error('zip_code') is-invalid @enderror">
            @error('zip_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Telefoonnummer</label>
            <input type="text" name="phone_number" value="{{ $company->phone_number }}"  class="form-control @error('phone_number') is-invalid @enderror">
            @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Email</label>
            <input type="email" name="email" value="{{ $company->email }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.companies.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Bedrijf opslaan</button>
                    </div>

                </form>
                </div>
</div>
</div>
</div>
</div>
@endsection
