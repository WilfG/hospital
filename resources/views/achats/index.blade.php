@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <a href="{{route('purchases.create')}}" class="btn btn-primary" title="Enregistrer un achat"><i class="fa fa-plus-circle"></i> Enregistrer un achat</a>


            <!-- ********************************************** -->

            @if (session('errors'))
            <div class="mb-4 font-medium text-sm text-green-600 alert alert-danger">
                {{ session('errors') }}
            </div>
            @endif
            @if (session('success'))
            <div class="mb-4 font-medium text-sm text-green-600 alert alert-success">
                {{ session('success') }}
            </div>
            @endif


            <table id="example-11" class="datatb display table table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Produit / Matériel</th>
                        <th>Quantité</th>
                        <th>Prix d'achat</th>
                        <th>Date d'acquisition</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($purchases as $purchase)
                    <tr>
                        <td>@if($purchase->type == 'product') {{'Produit'}} @else {{'Matériel'}} @endif</td>
                        <td>@if($purchase->drug_id) {{$purchase->drug->name}} @else {{$purchase->material->name}} @endif</td>
                        <td>{{$purchase->quantity}}</td>
                        <td>{{$purchase->cost}}</td>
                        <td>{{$purchase->purchase_date}}</td>
                        <td style="display:flex;">
                            <a href="{{route('purchases.edit', $purchase->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('purchases.destroy', $purchase->id)}}" method="POST">
                                @csrf
                                @METHOD('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
</section>
</div>
@endsection