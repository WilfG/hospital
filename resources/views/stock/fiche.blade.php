@extends('layout.index')

@section('content')
<h2>Stock Movements</h2>
<table class="display table table-hover table-condensed" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Type</th>
            <th>Produits/ Matériels</th>
            <th>Produits</th>
            <th>Quantité restante</th>
            <th>Date du mouvement</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stockMovements as $movement)
            @php 
                if($movement->item_type == 'product'){
                    foreach($drugs as $drug){
                        if($movement->item_id == $drug->id){   
                            $product_name = $drug->name;
                        }
                    }
                }
                if($movement->item_type == 'material'){
                    foreach($materials as $material){
                        if($movement->item_id == $material->id){   
                            $material_name = $material->name;
                        }
                    }
                }
            @endphp
            <tr>
                <td>@if($movement->type == 'entry') {{ 'Entrée' }}@elseif($movement->type == 'exit') {{'Sortie'}}@endif</td>
                <td>@if($movement->item_type == 'product'){{ 'Produit' }} @elseif($movement->item_type == 'material') {{'Matériel'}}@endif</td>
                <td>
                    @if($movement->item_type == 'product')
                        {{ $product_name }}
                    @else
                        {{ $material_name }}
                    @endif
                </td>
                <td>{{ $movement->quantity }}</td>
                <td>{{ $movement->movement_date }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
