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
                    <h1>Artikel toevoegen</h1>
                </div>
        </div>

            <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('admin.articles.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

            <div class="mb-3">
            <label for="">Titel</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control  @error('title') is-invalid @else @enderror" />
            @error('title')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Intro</label>
            <textarea type="text" name="intro" rows="4" class="form-control @error('intro') is-invalid @else @enderror">{{ old('intro') }}</textarea>
            @error('intro')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Beschrijving</label>
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

                    <div class="mb-3 row">
                        <div class="col">
                        <label class="form-label">Start datum</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @else @enderror" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
                        </div>
                        <div class="col">
                        <label class="form-label">Eind datum</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @else @enderror" name="end_date" value="{{ old('end_date') }}">
                    @error('end_date')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
                        </div>

                    </div>
                    <input type="hidden" name="user_id">

                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.articles.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Artikel toevoegen</button>
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

