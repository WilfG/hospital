@extends('layout.index')


@section('content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/'. auth()->user()->photo) }}" alt="Photo de profil" id="render_img" style="width: 100px; height: 100px;">
                            <!-- <span class="fa fa-pencil-alt" id="edit-avatar" style="position: absolute; cursor: pointer;"></span> -->


                            <h3 class="profile-username text-center">Ajouter un utilisateur</h3>


                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header p-2">
                        Informations Principales
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="principale">
                                @if (session('errors'))
                                <div class="mb-4 font-medium text-sm text-green-600 alert alert-danger">
                                    {{ session('errors') }}
                                </div>
                                @endif
                                @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600 alert alert-success">
                                    {{ session('status') }}
                                </div>
                                @endif


                                <form class="form-horizontal" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nom </label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Prénom</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}" id="firstname" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Mot de passe</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password" id="password" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Confirmer le mot de passe</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="photo" class="col-sm-2 col-form-label">Photo de profil</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" title="Choisir une photo" name="photo" id="photo" accept="jpeg,jpg,png,gif,PNG,JPG,JPEG">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Téléphone</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="{{old('phoneNumber')}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="role_id" class="col-sm-2 col-form-label">Rôles :</label>
                                        <div class="col-sm-10">
                                            <select name="role_id" class="form-control" required>
                                                <option value=""></option>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->role_label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">Enrégistrer</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>

                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="society">


                            </div>
                            <div class="tab-pane" id="security">

                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
    </div>
</section>
<!-- /.content -->
@endsection