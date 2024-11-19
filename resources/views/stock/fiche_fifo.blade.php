@extends('layout.index')

@section('content')
<h2>Mouvement du stock</h2>
<table class="display table table-hover table-condensed" cellspacing="0" width="100%">
    <thead>
        <!-- <tr>
            <th colspan="4">Entrée</th>
            <th colspan="4">Sorties</th>
        </tr> -->
        <tr>
            <th>Type</th>
            <th>Date</th>
            <th>Libellé</th>
            <th>Quantité</th>
            <th>Prix</th>
            <!-- <th>Date</th>
            <th>Libellé</th>
            <th>Quantité</th>
            <th>Prix</th> -->
        </tr>

    </thead>
    <tbody>

        @foreach($movements as $movement)
        <tr>
            <td>@if($movement->type == 'entry'){{ 'Entrée'}}@elseif($movement->type == 'exit') {{ 'Sortie'}} @endif</td>
            <td>{{$movement->movement_date}}</td>
            <td align="left">@if($movement->sale){{$movement->sale->drug->name}} @elseif($movement->purchase) {{$movement->purchase->drug->name}} @endif</td>
            <td align="left">{{$movement->quantity}}</td>
            <td align="left">@if($movement->sale) {{$movement->quantity * $movement->sale->sale_price}} @elseif($movement->purchase) {{$movement->quantity * $movement->purchase->cost}} @endif</td>
        </tr>
        @endforeach

    </tbody>
</table>

@endsection