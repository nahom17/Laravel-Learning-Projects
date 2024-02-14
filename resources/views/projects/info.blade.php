@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row flex-wrap">
        <div class="col-md-2">
            @include('layouts.inc.user-side-menu')
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                    <div class="col-md-4">
                        <h1>Mijn projecten</h1>
                    </div>
                    <div class="col-md-4">
                        {{-- zoek functie --}}
                    </div>
                    <div class="col-md-4">
                        <a href=""></a>
                    </div>
        </div>
        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item" role="presentation">
    <button class="nav-link" id="pills-info-tab" data-bs-toggle="pill" data-bs-target="#pills-info" type="button" role="tab" aria-controls="pills-info" aria-selected="true">Info</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-user-tab" data-bs-toggle="pill" data-bs-target="#pills-user" type="button" role="tab" aria-controls="pills-user" aria-selected="false">Gebruikers</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-task-tab" data-bs-toggle="pill" data-bs-target="#pills-task" type="button" role="tab" aria-controls="pills-task" aria-selected="false">Taken</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-company-tab" data-bs-toggle="pill" data-bs-target="#pills-company" type="button" role="tab" aria-controls="pills-company" aria-selected="false">Bedrijfgegevens</button>
    </li>
</ul>
    <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
    <div class="card mt-4">
        <div class="card-body">

            @if ($errors->any())
            <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                    <div>
                    {{$error}}
                    </div>
                    @endforeach
                </div>
                @endif
                @if (session()->has('message'))
                <div class="w-4/5 m-auto mt-10 pl-2">
                    <p class="w-2/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4">
                        {{ session()->get('message') }}
                    </p>
                </div>
            @endif

                        <table class="table  table-striped">
                        <thead>
                            <tr>

                                <th>Titel</th>
                                <th>Intro</th>
                                <th>Begin datum</th>
                                <th>Eind datum</th>



                            </tr>
                        </thead>
                        <tbody>


                            <tr>

                                <td>{{$project->title}}</td>
                                <td>{{$project->intro}}</td>
                                <td>{{ date('d-m-Y', strtotime($project->start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($project->end_date)) }}</td>

                            </tr>

                        </tbody>
                        </table>

        </div>
    </div>
    </div>
    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
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
                @if (session()->has('message'))
                    <div class="w-100 mt-4">
                        <p class="mb-4 text-light bg-success rounded p-4">
                            {{ session()->get('message') }}
                        </p>
                    </div>
                @endif
                <div class="col-md-12">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Rol</th>


                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($user as $user)
                                <tr>
                                    <td>{{ $user->user->name }}</td>
                                    <td>{{ $user->role->name }}</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <div class="tab-pane fade" id="pills-task" role="tabpanel" aria-labelledby="pills-task-tab">
    <div class="card mt-4">


                <div class="card-body">
                    @if (session()->has('message'))
            <div class="w-100 mt-4">
                <p class="mb-4 text-light bg-success rounded p-4">
                    {{ session()->get('message') }}
                </p>
            </div>
        @endif

                    @if (count($tasks))
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>

                                    <th>Taak</th>
                                    <th>Begin datum</th>
                                    <th>Eind datum</th>
                                    <th>Compleet</th>


                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->start_date }}</td>
                                        <td>{{ $task->end_date }}</td>
                                        <td>{{ ($task->Completed == '1' ? 'Afgrond' : 'open' && $task->completed == '0') ? 'Open' : 'Afgrond' }}
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <h2>je hebt geen taak</h2>
                        </div>
                    @endif
                </div>

            </div>
    </div>
    <div class="tab-pane fade" id="pills-company" role="tabpanel" aria-labelledby="pills-company-tab">
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
                @if (session()->has('message'))
                    <div class="w-100 mt-4">
                        <p class="mb-4 text-light bg-success rounded p-4">
                            {{ session()->get('message') }}
                        </p>
                    </div>
                @endif
                <div class="col-md-12">
                    <table class="table  table-striped">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Adres</th>
                                <th>Postcode</th>
                                <th>Telefoonnummer</th>
                                <th>E-mailadres</th>


                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($projectcompany as $project)
                                <tr>
                                    <td>{{$project->company->name }}</td>
                                    <td>{{$project->company->address }}</td>
                                    <td>{{$project->company->zip_code }}</td>
                                    <td>{{$project->company->phone_number }}</td>
                                    <td>{{$project->company->email }}</td>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
</div>
</div>
            </div>









        </div>

    </div>

</div>
@endsection
