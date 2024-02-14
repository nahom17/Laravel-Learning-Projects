@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row flex-wrap">
        <div class="col-md-2">
            @include('layouts.inc.admin-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                    <div class="col-md-4">
                        <h1>Categorieën</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.attributes.search') }}" method="GET"
                        class="">
                        <div class="input-group">
                            <input class="form-control" name="search" type="text" placeholder="Zoeken..."
                                aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                            <button class="btn btn-primary" id="btnNavbarSearch" type="submit"><i
                                    class="fas fa-search">zoeken</i></button>
                        </div>
                    </form>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Categorie toevoegen
</button>
                    </div>
        </div>
        <!-- Button trigger modal -->


<!-- add Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="{{ route('admin.attributes.store')}}" method="post">
            @csrf
                    <div class="mb-3">
                        <label for="">Naam</label>
                        <input type="text" name="name" id=""
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.attributes.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Categorie toevoegen</button>
                    </div>
        </form>
        </div>
    </div>
    </div>
</div>
{{-- end add modal --}}

{{-- start edit modal --}}

{{-- end edit modal --}}
        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                @if($attributes->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Bewerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attributes as $attribute)
                            <tr>
                                <td>{{ $attribute->name }}</td>
                                <td>
                                    <a href="" class="nav nav-link text-dark text-decoration-none" data-bs-toggle="modal" data-bs-target="#attribute{{$attribute->id}}">Bewerken</a>
                                    <div class="modal fade" id="attribute{{$attribute->id}}" tabindex="-1" aria-labelledby="editModalLabe1" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabe1">Categorie bewerken</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="{{ route('admin.attributes.update',$attribute)}}" method="post">
            @csrf
            @method('put')

                    <div class="mb-3">
                        <label for="">Naam</label>
                        <input type="text" name="name" id=""
                            class="form-control @error('name') is-invalid @enderror" value="{{ $attribute->name }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.attributes.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Categorie opslaan</button>
                    </div>
        </form>
        </div>
    </div>
    </div>
</div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.attributes.destroy', $attribute) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze categorie wilt verwijderen?');">Verwijderen</a>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen gategorie gevonden</h2>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

