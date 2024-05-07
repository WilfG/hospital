@extends('layout.index')

@section('content')
<h2>Mouvement du stock</h2>
<table class="display table table-hover table-condensed" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th colspan="4">Entrée</th>
            <th colspan="4">Sorties</th>
        </tr>
        <tr>
            <th>Date</th>
            <th>Libellé</th>
            <th>Quantité</th>
            <th>Prix</th>
            <th>Date</th>
            <th>Libellé</th>
            <th>Quantité</th>
            <th>Prix</th>
        </tr>

    </thead>
    <tbody>
        <tr>

            <td colspan="4">
                <table class="datatb display table table-hover table-condensed" width="100%">


                    @foreach($purchases as $purchase)
                    <tr>
                        <td>{{$purchase->purchase_date}}</td>
                        <td align="left">{{$purchase->drug->name}}</td>
                        <td align="left">{{$purchase->quantity}}</td>
                        <td align="left">{{$purchase->cost}}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
            <td colspan="4">
                <table class="display table table-hover table-condensed" width="100%">

                    @foreach($sales as $sale)

                    <tr>
                        <td>{{$sale->sale_date}}</td>
                        <td align="left">{{$sale->drug->name}}</td>
                        <td align="left">{{$sale->quantity}}</td>
                        <td align="left">{{$sale->sale_price}}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </tbody>
</table>

@endsection