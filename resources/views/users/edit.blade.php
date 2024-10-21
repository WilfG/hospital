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
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/'. $user->photo) }}" alt="Photo de profil" id="render_img" style="width: 100px; height: 100px;">
                            <!-- <span class="fa fa-pencil-alt" id="edit-avatar" style="position: absolute; cursor: pointer;"></span> -->

                        </div>

                        <h3 class="profile-username text-center">{{ $user->firstname }} {{ $user->lastname}}</h3>

                        <!-- <p class="text-muted text-center">{{ $user->poste }} à {{ $user->structure_name }}</p> -->

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

                               
                                <form class="form-horizontal" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="lastname" value="{{$user->lastname}}" id="lastname">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Prénom</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="firstname" value="{{ $user->firstname }}" id="firstname">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="photo" class="col-sm-2 col-form-label">Photo de profil</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" title="Choisir une photo" name="photo" id="photo" accept="jpeg,jpg,png,gif,PNG,JPG,JPEG">

                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="role" class="col-sm-2 col-form-label">Rôle</label>
                                        <div class="col-sm-10 col-md-6 ">
                                            <select class="form-control" name="role" id="role">
                                                @foreach($roles as $role)
                                                    @if($user->role_id == $role->id)
                                                        @php $userS = 'selected'; @endphp
                                                    @else
                                                        @php $userS = '' @endphp
                                                    @endif
                                                    <option value="{{$role->id}}" {{ $userS }}>{{$role->role_label}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Téléphone</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="phoneNumber" value="{{ $user->phoneNumber }}" id="phoneNumber">
                                            </div>
                                        </div>
                                    </div>




                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">Enrégistrer</button>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Mot de passe</label>
                                    <div class="col-sm-10">
                                        <div class="input-group" id="password">
                                            <form action="/password-update-request" method="post">
                                                @csrf
                                                @method('POST')
                                                <input type="email" name="email" value="{{ $user()->email }}" hidden />
                                                <button class="btn btn-secondary" type="submit">Changer mon mot de passe</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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