@extends('layout.index')

@section('content')

<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('users.create')}}" class="btn btn-primary" title="Enregistrer un nouvel utilisateur"><i class="fa fa-plus-circle"></i> Enregistrer un utilisateur</a>

                <!-- <a href="{{route('users.create')}}" class="btn btn-success pull right">Créer un utilisateur</a> -->
                <h3 class="card-title"> Liste des utilisateurs</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="button" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover tag_dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        @foreach ($roles as $role)
                        @if($role->id == $user->role_id)
                        @php $role_label = $role->role_label; @endphp
                        @endif
                        @endforeach
                        <tr>
                            <td>#</td>
                            <td>{{ $user->firstname . ' '. $user->lastname }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $role_label }}</td>

                            <td>
                                <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning btn-sm" title="Supprimer"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('users.destroy', [$user->id]) }} " method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Supprimer">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th>#</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

@endsection