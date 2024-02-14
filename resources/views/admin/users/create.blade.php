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
                     <h1>Gebruiker toevoegen</h1>
                   </div>
        </div>



            <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                        <form action="{{ route('admin.users.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

            <div class="mb-3">
                            <label>{{ __('Naam') }}</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        <div class="mb-3">
                            <label>{{ __('Email') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{ __('Wachtwoord') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label>{{ __('Bevestig wachtwoord') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="mb-3">
                        <div class="mb-3">
                            <input type="hidden" name="role_id"  class="form-control">
                        </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.users.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Gebruiker toevoegen</button>
                    </div>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
