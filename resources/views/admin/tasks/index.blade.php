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
                        <h1>Taken</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.tasks.search') }}" method="GET"
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
                        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary float-end">Taak toevoegen</a>
                    </div>
        </div>
        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                @if($tasks->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>
                        <th>Taak</th>
                        <th>Project</th>
                        <th>Gebruiker</th>
                        <th>Begin datum</th>
                        <th>Eind datum</th>
                        <th>Compleet</th>
                        <th>Bewerken</th>
                        <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{$task->project->title}}</td>
                                <td>{{$task->user->name}}</td>
                                <td>{{ date('d-m-Y', strtotime($task->start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($task->end_date)) }}</td>
                                <td>{{$task->Completed == '1' ? "Afgrond" : 'open' && $task->completed == '0' ? "Open" : 'Afgerond'}}</td>
                                <td>
                                    <a href="{{ route('admin.tasks.edit',$task) }}"
                                        class="nav nav-link text-dark text-decoration-none">Bewerken</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.tasks.destroy', $task) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze Taak wilt verwijderen?');">Verwijderen</a>
                                </td>
                                <td></td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen taak gevonden</h2>
                </div>
                @endif
            </div>

        </div>

    </div>

</div>
 @endsection

