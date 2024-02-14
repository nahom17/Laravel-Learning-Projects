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
                        <h1>Product bewerken</h1>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('admin.products.accessories.search',$product) }}" method="GET"
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
                        <a href="{{ route('admin.products.accessories.create',$product) }}" class="btn btn-primary float-end">Configrator toevoegen</a>
                    </div>
        </div>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a  href="{{ route('admin.products.edit',$product->id) }}" class="nav-link" id="nav-projects-tab">Info</a>
    <a href="{{ route('admin.products.accessories.index',$product->id) }}" class="nav-link active" id="nav-profile-tab">Configuratie</a>
    </div>
        <div class="card-body">
            @if (session('message'))
            <div class="alert alert-success text-center"> {{ session('message') }}
                <button class="closebtn float-end" onclick="this.parentElement.style.display='none';">X</button>
            </div>
                @endif
                @if($accessories->isNotEmpty())
                <table class="table  table-striped">
                    <thead>
                        <tr>
                            <th>Categorie</th>
                            <th>Naam</th>
                            <th>Prijs</th>
                            <th>Korting prijs</th>
                            <th>Btw</th>
                            <th>Bewerken</th>
                            <th>Verwijderen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accessories as $accessory)
                            <tr>
                                <td>{{ $accessory->attribute->name }}</td>
                                <td>{{ $accessory->name }}</td>
                                <td>&euro; {{ number_format($accessory->price, 2, ',', '.') }}</td>
                                <td>&euro; {{ number_format($accessory->discount_price, 2, ',', '.') }}</td>
                                <td>{{ $accessory->vat }}&percnt;</td>
                                <td>
                                    <a href="{{ route('admin.products.accessories.edit',[$product, $accessory]) }}"
                                        class="nav nav-link text-dark text-decoration-none">Bewerken</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.accessories.destroy',[$product, $accessory]) }}"
                                        class="nav nav-link text-dark text-decoration-none"
                                        onclick="return confirm('Weet u zeker dat u deze configrator wilt verwijderen?');">Verwijderen</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-center align-items-center">
                    <h2>Er is geen Configrator gevonden</h2>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

