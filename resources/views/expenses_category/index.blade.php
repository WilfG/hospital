@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

        <a href="{{route('categ_expenses.create')}}" class="btn btn-primary" title="Enregistrer une catégorie de dépense"><i class="fa fa-plus-circle"></i> Enregistrer une catégorie de dépense</a>


            <!-- ********************************************** -->
            <h2>Liste des catégories de dépense</h2>

            <table id="example-11" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Libellé</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categories as $categorie)
                    <tr>
                        <td>#</td>
                        <td>{{$categorie->label}}</td>
                        <td>
                            <!-- <a href="{{route('categ_expenses.show', $categorie->id)}}" class="btn btn-primary btn-xs" data-toggle="tooltip" title=""><i class="fa fa-eye"></i></a> -->
                            <a href="{{route('categ_expenses.edit', $categorie->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs"><i class="fa fa-edit "></i> </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- ********************************************** -->




        </div>
    </div>
</div>
</section>
</div>
@endsection