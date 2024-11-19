@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <a href="{{route('materiels.create')}}" class="btn btn-primary" title="Enregistrer un matériel"><i class="fa fa-plus-circle"></i> Enregistrer un matériel</a>

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
                        <th>Date</th>
                        <th>Libellé</th>
                        <th>Quantité</th>
                        <th>Type de mouvement</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($movements as $mov)
                    <tr>
                        <td>#</td>
                        <td>{{$mov->created_at}}</td>
                        <td>{{$mov->material->name}}</td>
                        <td>{{$mov->quantity}}</td>
                        <td>@if($mov->movement_type == 'exit') {{'sortie'}} @else {{'entrée'}} @endif</td>
                        <td style="display:flex;">
                            <a href="{{route('materiels.edit', $mov->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('magasins.destroy', $mov->id)}}" method="POST">
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
@endsection