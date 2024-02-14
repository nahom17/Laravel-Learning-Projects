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
                        <h1>Gebruiker bewerken</h1>
                    </div>
        </div>
            <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                        <form action="{{ route('admin.users.update',$user)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

            <div class="mb-3">
                            <label>Naam</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        <div class="mb-3">
                            <label>Email</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="mb-3">
                        <label>Rollen</label>
                        <select name="role_id" id="select2" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">Gebruiker</option>
                            </select>
                        </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.users.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Gebruiker opslaan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
