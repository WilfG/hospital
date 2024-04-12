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

            <a href="{{route('expenses_requests.create')}}" class="btn btn-primary" title="Enregistrer une dépense"><i class="fa fa-plus-circle"></i> Enregistrer une requete</a>

            <table id="example-11" class="display table table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Numéro</th>
                        <th>Motif</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Etat</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($expensesReq as $req)
                    @if($req->status == 'pending')
                    @php $etat = 'En cours de validation'; $color = 'warning'; @endphp
                    @elseif($req->status == 'completed')
                    @php $etat = 'Requête validée'; $color = 'success'; @endphp
                    @endif
                    <tr>
                        <td>{{$req->user->lastname . ' '. $req->user->firstname}}</td>
                        <td>{{$req->code}}</td>
                        <td>{{$req->reason}}</td>
                        <td>{{$req->amount}}</td>
                        <td>{{$req->expense_date}}</td>
                        <td>{{$req->note}}</td>
                        <td>{{$etat}}</td>
                        <td style="display:flex;">
                            @if($canValidate)
                            <form action="{{route('validate_expense_request')}}" method="POST">
                                @csrf
                                @METHOD('PUT')
                                <input type="hidden" name="vldtor" value="{{auth()->user()->id}}">
                                <input type="hidden" name="to_be_vldt" value="{{$req->id}}">
                                <button type="submit" class="btn btn-{{$color}} btn-sm" title="Valider"><i class="fa fa-check"></i></button>
                            </form>
                            @endif

                            @if($req->status != 'completed')
                            <a href="{{route('expenses_requests.edit', $req->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;" title="Modifier"><i class="fa fa-pencil" ></i></a>
                            <form action="{{route('expenses_requests.destroy', $req->id)}}" method="POST">
                                @csrf
                                @METHOD('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                            </form>
                            @else
                            <a role="link" aria-disabled="true" disabled class="btn btn-warning btn-sm" style="margin: 2px;" title="Modifier"><i class="fa fa-pencil" ></i></a>
                            <form action="{{route('expenses_requests.destroy', $req->id)}}" method="POST">
                                @csrf
                                @METHOD('DELETE')
                                <button type="submit" disabled="disabled" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                            </form>
                            @endif

                            @if($req->status == 'completed')
                             <a href="{{route('expense_create', $req->id)}}" class="btn btn-primary btn-sm" style="margin: 2px;" title="Enregistrer la dépense"><i class="fa fa-plus" ></i></a>
                            @endif
                            <a class="btn btn-default  btn-sm downloadBtn" data-line-id="{{ $req->id }}" title="Télécharger le fichier joint"><i class="fa fa-download"></i>  </a>
                           
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection