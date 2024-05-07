@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <a href="{{route('consultations.create')}}" class="btn btn-primary" title="Enregistrer une consultation"><i class="fa fa-plus-circle"></i> Enregistrer une consultation</a>

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
                        <th>Patient</th>
                        <th>Motif</th>
                        <th>Traitements</th>
                        <th>Examens</th>
                        <th>Diagnostic</th>
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach($consultations as $consultation)
                    <tr>
                        <td>#</td>
                        <td>{{$consultation->patient->firstname }} {{$consultation->patient->lastname }}</td>
                        <td>{{$consultation->motif}}</td>
                        <td>{!!$consultation->traitements!!}</td>
                        <td>{!!$consultation->diagnostic!!}</td>
                        <td>{!!$consultation->examens!!}</td>
                        <td style="display:flex;">
                            <a href="{{route('consultations.edit', $consultation->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('consultations.destroy', $consultation->id)}}" method="POST">
                                @csrf
                                @METHOD('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                            </form>
                             <a href="{{route('consultations.show', $consultation->id)}}" class="btn btn-primary btn-sm" title="Fiche de stock"><i class="fa fa-eye"></i></a>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection