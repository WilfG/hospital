@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="{{route('usages.create')}}" class="btn btn-primary" title="Enregistrer une sortie"><i class="fa fa-plus-circle"></i> Enregistrer une sortie de produit</a>
        </div>
        

        <div class="col-md-12 col-sm-12 col-xs-12">



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
                        <th>Matériel</th>
                        <th>Quantité</th>
                        <th>Prix de sortie</th>
                        <th>Date de sortie</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($usages as $sale)
                    <tr>
                        <td>#</td>
                        <td>{{$sale->quantity}}</td>
                        <!-- <td>{{$sale->sale_price}}</td> -->
                        <td>{{$sale->sale_date}}</td>
                        <td style="display:flex;">
                            <!-- <a href="{{route('sales.edit', $sale->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a> -->
                            <form action="{{route('usages.destroy', $sale->id)}}" method="POST" onsubmit="return confirmDelete()">
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