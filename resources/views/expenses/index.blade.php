@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
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

            <a href="{{route('expenses.create')}}" class="btn btn-primary" title="Enregistrer une dépense"><i class="fa fa-plus-circle"></i> Enregistrer une dépense</a>

            <table id="example-11" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Motif</th>
                        <th>Montant</th>
                        <th>Catégorie</th>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td>{{$expense->user->lastname . ' '. $expense->user->firstname}}</td>
                        <td>{{$expense->reason}}</td>
                        <td>{{$expense->amount}}</td>
                        <td>{{$expense->expenses_category->label}}</td>
                        <td>{{$expense->expense_date}}</td>
                        <td>{{$expense->note}}</td>
                        <td style="display:flex;">
                            <a href="{{route('expenses.edit', $expense->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('expenses.destroy', $expense->id)}}" method="POST">
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