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
                        <h1>Mijn Artikelen</h1>
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
                @if($articles->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>

                            <th>Titel</th>
                            <th>Intro</th>
                            <th>Begin datum</th>
                            <th>Eind datum</th>
                            {{-- <th>Bewerken</th>
                            <th>Verwijderen</th> --}}
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($articles as $article)
                            <tr>

                                <td>{{ $article->title }}</td>
                                <td>{{ $article->intro }}</td>
                                <td>{{ date('d-m-Y', strtotime($article->start_date)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($article->end_date)) }}</td>
                                {{-- <td>
                                    <a href="{{ route('admin.articles.edit',$article) }}"
                                        class="nav nav-link text-dark text-decoration-none">Bewerken</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.articles.destroy', $article) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze artikel wilt verwijderen?');">Verwijderen</a>
                                </td>
                                <td></td> --}}

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen artikel gevonden</h2>
                </div>
                @endif
            </div>









        </div>

    </div>

</div>
@endsection
