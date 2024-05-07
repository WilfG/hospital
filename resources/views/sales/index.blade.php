@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <a href="{{route('sales.create')}}" class="btn btn-primary" title="Enregistrer une sortie"><i class="fa fa-plus-circle"></i> Enregistrer une sortie</a>


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
                        <th>#</th>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix de sortie</th>
                        <th>Date de sortie</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td>#</td>
                        <td>{{$sale->drug->name}}</td>
                        <td>{{$sale->quantity}}</td>
                        <td>{{$sale->sale_price}}</td>
                        <td>{{$sale->sale_date}}</td>
                        <td style="display:flex;">
                            <a href="{{route('sales.edit', $sale->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('sales.destroy', $sale->id)}}" method="POST">
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