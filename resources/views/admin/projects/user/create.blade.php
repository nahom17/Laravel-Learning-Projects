@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row flex-nowrap">
            <div class="col-md-2">
                @include('layouts.inc.admin-side-menu')
            </div>
            <div class="col-md-10">
                <div class="row align-items-center py-3">
                    <div class="col-md-6">
                        <h1>Gebruiker koppelen</h1>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-4">
                        <div class="dropdown float-end">
                            <div class="dropdown-toggle p-2 btn btn-primary" type="link" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Opties
                            </div>
                            <ul class="dropdown-menu">

                                <li><span class="dropdown-item-text"></span></li>
                                <li>

                                    <a href="" class="dropdown-item">Taak toevoegen</a>
                                    <a href="{{ route('admin.projects.users.userAdd', $project->id) }}"
                                        class="dropdown-item">Gebruiker koppelen</a>
                                    {{-- <a href="{{ route('companies.addpersoncompany') }}" class="dropdown-item">Persoon koppelen</a> --}}
                            </ul>
                        </div>
                    </div>



                </div>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a  href="" class="nav-link" id="nav-projects-tab">Info</a>
    <a href="{{ route('admin.projects.users.indexUser',$project->id) }}" class="nav-link active" id="nav-profile-tab">Gebruikers</a>
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
                        <form action="{{ route('admin.projects.users.userStore', $project) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf


                            <div class="mb-3">
                                <label for="">Gebruiker</label>
                                <select class="form-select @error('user_id') is-invalid @else @enderror" name="user_id"
                                    id="select1" data-placeholder="zoke een gebruiker">

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="">Rol</label>
                                <select class="form-select @error('role_id') is-invalid @else @enderror" name="role_id"
                                    id="select2" data-placeholder="keis een project">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex float-end">
                                <a href="{{ route('admin.projects.users.indexUser', $project->id) }}" class="nav-link me-3">Annuleren</a>
                                <button type="submit" class="btn btn-primary">Gebruiker koppelen</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
