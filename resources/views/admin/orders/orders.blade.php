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
                        <h1>Bestellingen</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.orders.search') }}" method="get"
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
                        <a href="{{ route('admin.orders.createOrder') }}" class="btn btn-primary float-end">Bestelling toevoegen</a>
                    </div>
        </div>
        <div class="card-body">
        @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                @if($orders->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>

                            <th>Id</th>
                            <th>Totaal prijs</th>
                            <th colspan="3">Klant</th>
                            <th>Status</th>
                            <th>datum</th>
                            <th>Bewerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders   as $order)
                            <tr>
                                <td>#{{ $order->id}}</td>
                                <td>&euro;{{ number_format($order->total_amount, 2, ',', '.') }}</td>
                                <td colspan="3">{{ $order->name }}</td>
                                <td> @if($order->status == 0)
                            Bestelling
                            @elseif($order->status == 1)
                            Offerte
                                    @else
                            Factuur
                                        @endif</td>
                                <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.view',$order) }}"
                                        class="nav nav-link text-dark text-decoration-none">Bewerken</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.destroy',$order) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze bestelling wilt verwijderen?');">Verwijderen</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen Bestelling  gevonden</h2>
                </div>
                @endif
            </div>
            {{$orders->links()}}
        </div>

    </div>

</div>
 @endsection

