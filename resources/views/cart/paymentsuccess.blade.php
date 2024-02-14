@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row flex-wrap">
        <div class="col-md-2">
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                    <div class="col-md-4">
                        <h1></h1>
                    </div>
                    <div class="col-md-4">
                        {{-- zoek functie --}}
                    </div>
                    <div class="col-md-4">
                        <a href=""></a>
                    </div>
        </div>

<div class="card">
<div class="card-body">
Bedankt! Uw bestelling is geplaatst. <br>
Een e-mailbevestiging met de details over uw bestelling is naar uw email
verzonden.

</div>
            </div>
            <div class="d-flex float-end mt-4">
            <a href="{{ route('products.productIndex') }}" class=" btn btn-primary  ms-2">Producten</a>
                </div>
</div>








        </div>

    </div>

</div>
 @endsection
