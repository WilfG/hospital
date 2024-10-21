@extends('layout.index')


@section('content')

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
    @METHOD('POST')
    <div class="form-group row">
        <label for="lastname" class="col-sm-2 control-label form-label">Nom </label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}" id="lastname" required>

        </div>
    </div>

    <div class="form-group row">
        <label for="firstname" class="col-sm-2 control-label form-label">Prénom</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="firstname" value="{{old('firstname')}}" id="firstname" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-2 control-label form-label">Email</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 control-label form-label">Mot de passe</label>
        <div class="col-sm-8">
            <input type="password" name="password" id="password" class="form-control" required />
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 control-label form-label">Confirmer le mot de passe</label>
        <div class="col-sm-8">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
        </div>
    </div>

    <div class="form-group row">
        <label for="photo" class="col-sm-2 col-form-label">Photo de profil</label>
        <div class="col-sm-8">
            <input type="file" class="form-control" title="Choisir une photo" name="photo" id="photo" accept="jpeg,jpg,png,gif,PNG,JPG,JPEG">

        </div>
    </div>

    <div class="form-group row">
        <label for="phoneNumber" class="col-sm-2 col-form-label">Téléphone</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="{{old('phoneNumber')}}" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="role_id" class="col-sm-2 col-form-label">Rôles :</label>
        <div class="col-sm-8">
            <select name="role_id" id="role_id" class="form-control" required>
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

@endsection