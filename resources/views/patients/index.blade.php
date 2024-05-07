@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <a href="{{route('patients.create')}}" class="btn btn-primary" title="Enregistrer un patient"><i class="fa fa-plus-circle"></i> Enregistrer un patient</a>

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
                        <th>#</th>
                        <th>Prénoms</th>
                        <th>Nom</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($patients as $patient)
                    <tr>
                        <td>#</td>
                        <td>{{$patient->firstname}}</td>
                        <td>{{$patient->lastname}}</td>
                        <td style="display:flex;">
                            <a href="{{route('patients.edit', $patient->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('patients.destroy', $patient->id)}}" method="POST">
                                @csrf
                                @METHOD('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                            </form>
                             <a href="{{route('patients.show', $patient->id)}}" class="btn btn-primary btn-sm" title="Dossier"><i class="fa fa-eye"></i></a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection