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
                        <h1>Producten</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.products.search') }}" method="GET"
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
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary float-end">Product toevoegen</a>
                    </div>
        </div>
        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                @if($products->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th colspan="3">Naam</th>
                            <th>Prijs</th>
                            <th>Korting prijs</th>
                            <th>Btw</th>
                            <th>Bewerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td colspan="3">{{ $product->name }}</td>
                                <td>&euro; {{ number_format($product->price, 2, ',', '.') }}</td>
                                <td>&euro; {{ number_format($product->discount_price, 2, ',', '.') }}</td>
                                <td>{{ $product->vat }}&percnt;</td>
                                <td>
                                    <a href="{{ route('admin.products.edit',$product) }}"
                                        class="nav nav-link text-dark text-decoration-none">Bewerken</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.destroy', $product) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze product wilt verwijderen?');">Verwijderen</a>
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen product gevonden</h2>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

