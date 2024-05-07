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
            <a href="{{route('roles.create')}}" class="btn btn-primary" title="Enregistrer un nouveau rôle"><i class="fa fa-plus-circle"></i> Enregistrer un nouveau rôle</a>

            <table id="example-11" class="datatb display table table-hover table-condensed" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Libellé du rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>#</td>
                        <td>{{$role->role_label}}</td>

                        <td style="display:flex;">
                            <a href="{{route('roles.edit', $role->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                            <form action="{{route('roles.destroy', $role->id)}}" method="POST">
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