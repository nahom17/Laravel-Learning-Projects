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
                        <h1>Gebruikers</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.users.search') }}" method="GET"
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
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary float-end">Gebruiker toevoegen</a>
                    </div>
        </div>
        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                @if($users->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>

                            <th>Naam</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Bewerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                            <tr>

                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{$user->role->name}}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit',$user) }}"
                                        class="nav nav-link text-dark text-decoration-none">Bewerken</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.destroy', $user) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze gebruiker wilt verwijderen?');">Verwijderen</a>
                                </td>
                                <td></td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen gebruiker gevonden</h2>
                </div>
                @endif
            </div>

        </div>

    </div>

</div>
 @endsection

