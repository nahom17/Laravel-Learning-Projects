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
                        <h1>Project Info</h1>
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="dropdown float-end">
<div class="dropdown-toggle p-2 btn btn-primary" type="link" data-bs-toggle="dropdown" aria-expanded="false">
Opties
</div>
<ul class="dropdown-menu">

<li><span class="dropdown-item-text"></span></li>
<li>

<a href="" class="dropdown-item">Taak toevoegen</a>
<a href="{{ route('admin.projects.users.userAdd',$project->id) }}" class="dropdown-item">Gebruiker koppelen</a>
{{-- <a href="{{ route('companies.addpersoncompany') }}" class="dropdown-item">Persoon koppelen</a> --}}
</ul>
</div>
                    </div>
        </div>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a  href="" class="nav-link active" id="nav-projects-tab">Info</a>
    <a href="{{ route('admin.projects.users.indexUser',$project->id) }}" class="nav-link" id="nav-profile-tab">Gebruikers</a>
    <a href="{{ route('admin.projects.tasks.indexTask',$project->id) }}" class="nav-link" id="nav-contact-tab">Taken</a>
    <a href="{{ route('admin.projects.companies.indexCompany',$project->id)}}" class="nav-link" id="nav-contact-tab">Bedrijfsgegevens</a>
    </div>
            <div class="card">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('admin.projects.update',$project)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

            <div class="mb-3">
            <label for="">Titel</label>
            <input type="text" name="title" value="{{ $project->title}}" class="form-control @error('title') is-invalid @enderror" />
            @error('title')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Intro</label>
            <textarea type="text" name="intro" rows="4" class="form-control @error('intro') is-invalid @enderror">{{$project->intro }}</textarea>
            @error('intro')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Beschrijving</label>
            <textarea  id="description" name="description"     class="form-control @error('description') is-invalid @enderror">{{ $project->description }}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
            <div class="mb-3">
            <label for="">Selecteer een bestand</label>
            <input type="file" name="image" value="{{ $project->image }}" class="form-control @error('image') is-invalid @enderror" />
            <img class="card-img-fluid rounded-start mt-1" style="width:10%;" src="{{ asset('uploads/project/' .$project->image)}}" alt="{{$project->image}}">{{ $project->image }}
            @error('image')
            <div class="alert alert-danger">{{ $message }}</div><span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
                    <div class="mb-3 row">
                        <div class="col">
                        <label class="form-label">Start datum</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ $project->start_date }}">
                        @error('start_date')
                    <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                        @enderror
                        </div>
                        <div class="col">
                        <label class="form-label">Eind datum</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ $project->end_date }}">
                    @error('end_date')
                        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                    @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                    <label for="">Bedrijf</label>
                    <select class="form-select @error('company_id') is-invalid @else @enderror" name="company_id" id="select1">
                        @php
                        $companies = App\Models\Company::orderBy('name')->get();
                        @endphp
                        @foreach ( $companies as $company )
                        <option value="{{  $company->id}}">{{  $company->name}}</option>
                        @endforeach
                    </select>
                    @error('company_id')
                        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
                    </div>
                    <div class="mb-3 d-flex float-end">
                        <a href="{{ route('admin.projects.index')}}" class="nav-link me-3">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Project opslaan</button>
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
