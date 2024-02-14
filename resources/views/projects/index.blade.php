@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row align-items-center py-3">
        <div class="col-md-4">
            <h1>Projecten</h1>
        </div>
        <div class="col-md-4">

        </div>
        @if(Auth::check())
        <div class="col-md-4">
            {{-- <a href="{{ route('user.post.create') }}" class="btn btn-primary float-end">Artikel toevoegen</a> --}}
        </div>
        @endif
    </div>
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
            <div class="w-100 mt-4">
                <p class="mb-4 text-light bg-success rounded p-4">
                    {{ session()->get('message') }}
                </p>
            </div>
        @endif



    <div class="row align-items-start py-3">
        @if($projects->isNotEmpty())
        @foreach ($projects as $project)
        @if($project->end_date >= now())
        <div class="col-md-4">
            <div class="card-group">
                     <div class="card">
            <a href="{{ route('projects.show',$project) }}" class="nav nav-link mr-2"><img class="card-img-top w-100" src="{{ asset('uploads/project/' .$project->image)}}" alt="{{$project->image}}"></a>
    <div class="card-body">
      <h1 class="card-title">{{$project->title }}</h1>
          <h5 class="card-subtitle mb-2 text-muted">{{ $project->intro }}</h5>
          <p class="card-subtitle">Dit project is open  tot {{ date('d-m-Y', strtotime($project->end_date)) }}</p>
        <a href="{{ route('projects.show',$project) }}" class="text-decoration-none">Bekijk project</a>
    </div>
    </div>
            </div>

    </div>
    @endif
    @endforeach
    </div>
  <div class="mt-5">
    {{$projects->links()}}
   </div>
   @else
   <span class="text-center">Er is geen project gevonden</span>
  </div>
  @endif

@endsection
