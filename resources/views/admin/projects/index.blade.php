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
                        <h1>Projecten</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.projects.search') }}" method="GET"
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
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary float-end">Project toevoegen</a>
                    </div>
        </div>
        <div class="card-body">
                @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                @if($projects->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>

                            <th>Titel</th>
                            <th>Intro</th>
                            <th>Begin datum</th>
                            <th>Eind datum</th>
                            <th>Bewerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($projects as $project)
                            <tr>

                                <td>{{ $project->title }}</td>
                                <td>{{ $project->intro }}</td>
                                <td>{{ date('d-m-Y', strtotime($project->start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($project->end_date)) }}</td>
                                <td>
                                    <a href="{{ route('admin.projects.edit',$project) }}"
                                        class="nav nav-link text-dark text-decoration-none">Bewerken</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.projects.destroy', $project) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze project wilt verwijderen?');">Verwijderen</a>
                                </td>
                                <td></td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen project gevonden</h2>
                </div>
                @endif
            </div>

        </div>

    </div>

</div>
 @endsection

