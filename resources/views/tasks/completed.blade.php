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
                        <h1>Afgeronde taken</h1>
                    </div>
                    <div class="col-md-4">
                        {{-- zoek functie --}}
                    </div>
                    <div class="col-md-4">
                        <a href=""></a>
                    </div>
        </div>
        {{-- <div class="card"> --}}
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a href="{{ route('tasks.openTask') }}" class="nav-link" id="nav-profile-tab">Open</a>
    <a href="{{  route ('tasks.completedTask')}}" class="nav-link active" id="nav-contact-tab">Afgerond</a>
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
                        <th>Begin datum</th>
                        <th>Eind datum</th>
                        <th>Compleet</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task )
                    <tr>

                        <td>{{$task->title}}</td>
                        <td>{{$task->project->title}}</td>
                        <td>{{date('d-m-Y', strtotime($task->start_date))}}</td>
                        <td>{{date('d-m-Y', strtotime($task->end_date))}}</td>
                        <td><div class="col">
                                        <form action="{{ route('tasks.isOpened',['task'=>$task]) }}" method="post" class="inline">
                                                    @csrf
                                                    @method('PUT')

                                            <button type="submit" class="btn btn-secondary">Open</button>
                                        </form>
                                    </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="col-md-8 text-center mt-3">Je hebt geen open taken</div>
            @endif
        </div>
            {{-- </div> --}}
        </div>

    </div>

</div>
@endsection
