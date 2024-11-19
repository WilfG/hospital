@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">


        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <a href="{{route('recettes.create')}}" class="btn btn-primary" title="Enregistrer une sortie"><i class="fa fa-plus-circle"></i> Enregistrer une recette</a>
        </div>

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

          
            <table id="example-11" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Montant</th>
                        <th>Auteur</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($recettes as $recette)
                    <tr>
                        <td>{{$recette->label}}</td>
                        <td>{{$recette->cost}}</td>
                        <td>{{$recette->user->lastname}}</td>
                        <td style="display:flex;">
                            <a href="{{route('recettes.edit', $recette->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('recettes.destroy', $recette->id)}}" method="POST">
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