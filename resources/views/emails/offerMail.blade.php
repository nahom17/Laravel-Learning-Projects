<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
padding-top: 12px;
padding-bottom: 12px;
text-align: left;
background-color: #04AA6D;
color: white;
}
</style>
</head>
<body>
@php
$total = 0;
$total_vat = 0;
$total_price_excl = 0;
$total_discount = 0;
@endphp
<div class="container">
    <div class="row flex-wrap">
        <div class="col-md-2">
        </div>
        <div class="col-md-10">
        <div class="row align-items-center py-3">
                    <div class="col-md-4">
                        <h1>Offerte #{{$order->id}}</h1>
                    </div>
        </div>
        <div class="card-body">
            @if (session()->has('message'))
            <div class="w-100 mt-4">
                <p class="mb-4 text-light bg-success rounded p-4">
                    {{ session()->get('message') }}
                </p>
            </div>
        @endif
            </div>
            <div class="row align-items-top">
                <div class="col-md-8">
                    <span>{{ $order->name }}</span><br>
                    <span>{{ $order->address }}</span><br>
                    <span>{{ $order->zipcode }} {{ $order->city }}</span><br>
                    <span>{{ $order->email }}</span><br>
                    <span>{{ $order->phone_number }}</span><br>
                </div>
                <div class="col-md-4">
                <span class="float-end">{{ date('d-m-Y', strtotime($order->created_at)) }}</span>
                </div>
            </div>
                <table id="customers">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Prijs excl</th>
                        <th>Kroting prijs excl</th>
                        <th>Aantal</th>
                        <th>Excl Btw</th>
                        <th>Btw</th>
                        <th>Incl Btw</th>
                    </tr>
                </thead>
                @foreach ($order->products as $item)
                    <tbody>
                        @php
                                if ($item->product->discount_price) {
                                $total += $item->product->discount_price * $item->quantity * ($item->product->vat / 100) + $item->product->discount_price * $item->quantity;
                                $total_price_excl += $item->product->discount_price * $item->quantity;
                                $total_vat += $item->product->discount_price * $item->quantity * ($item->product->vat / 100);
                                $total_discount += ($item->product->price * $item->quantity) - ($item->product->discount_price * $item->quantity);
                                }
                                else
                                {
                                $total += $item->product->price * $item->quantity * ($item->product->vat / 100) + $item->product->price * $item->quantity;
                                $total_price_excl += $item->product->price *$item->quantity;
                                $total_vat +=$item->product->discount_price ? ($item->product->discount_price) * $item->quantity * ($item->product->vat / 100) : ($item->product->price) * $item->quantity * ($item->product->vat / 100);
                                }

                                @endphp
                        <tr data-id="{{ $order }}">
                            <td data-th="Product">
                                <p>{{ $item->product->name }}</p>
                                @foreach($order->accessories->whereIn('product_id',$item->product->id ) as $productarribute)
                                {{$productarribute->accessory->name}} +&euro;{{number_format($productarribute->accessory->discount_price, 2, ',', '.')}} <br>
                            @endforeach
                            </td>
                            <td>&euro;{{ number_format($item->product->price, 2, ',', '.') }}</td>
                            <td>&euro;{{ number_format($item->discount_price, 2, ',', '.') }}</td>
                            <td data-th="Quantity">
                                {{$item->quantity}}
                            </td>
                            <td data-th="Subtotal" class="text-center">
                                @if($item->discount_price)
                                &euro;{{ number_format($item->discount_price * $item->quantity + $productarribute->accessory->discount_price * $item->quantity, 2, ',', '.') }}
                                @else
                                &euro;{{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                @endif</td>
                            <td data-th="Subtotal" class="text-center">{{ $item->product->vat }}&percnt;</td>
                            <td data-th="incl_vat" class="text-center">
                                @if($item->discount_price)
 &euro;{{ number_format(($item->discount_price * $item->quantity)*$item->product->vat/100+$item->discount_price*$item->quantity+ $item->product->vat/100+ ($productarribute->accessory->discount_price * $item->quantity)*$productarribute->accessory->vat/100+$productarribute->accessory->discount_price * $item->quantity-1.02+0.81 , 2, ',', '.') }}                                @else
                                 &euro;{{ number_format(($item->discount_price * $item->quantity )*$item->product->vat/100+$item->product->price*$item->quantity, 2, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                @endforeach
                </tbody>
                </table>
                <div class="float-end">
                    @if($item->discount_price)
                <p>Korting: &euro;{{ number_format($total_discount-$productarribute->accessory->discount_price * $item->quantity, 2, ',', '.') }}</p>
                @endif
                    <p>Exclusief btw : &euro; {{ number_format($order->total_price_excl, 2, ',', '.') }}</p>
                <p>Btw : &euro;{{ number_format($order->total_vat, 2, ',', '.') }}</p>
                <p>Inclusief btw : &euro;{{ number_format($order->total_amount, 2, ',', '.') }}</p>

                </div><br>
                </div>
</div>
</div>
</body>
</html>