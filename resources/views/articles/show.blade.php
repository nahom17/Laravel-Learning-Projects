@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card-hidden mb-4">
        <div class="row align-items-start mt-4">
          <div class="col-md-4">
            <h1>Artikel</h1>
          </div>
          <div class="col">

          </div>
          <div class="col">

          </div>
        </div>
      </div>
<div class="container">
    <div class="row g-0">
      <div class="col-md-2">
        <img class="card-img-fluid rounded-start w-100 mt-4" src="{{ asset('uploads/article/' .$article->image)}}" alt="{{$article->image}}">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h1 class="card-title">{{$article->title}}</h1><br>
          <h5 class="card-subtitle mb-2 text-muted">{{$article->intro}}</h5>
           <p class="card-subtitle">Dit artikel is leesbaar  tot {{ date('d-m-Y', strtotime($article->end_date)) }}</p>
           <p class="card-text">{!! $article->description!!}</p>
          <div class="item-link mt-3">
            <a href="{{route('articles.index')}}" class="text-decoration-none mb-3">Terug</a>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
