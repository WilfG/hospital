@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Administrer le ticket</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Accueil</a>
                </li>
                <li>
                    <a href="hos-patients.html">Tickets</a>
                </li>
                <li class="active">
                    <strong>Administrer le ticket</strong>
                </li>
            </ol>
        </div>

    </div>
</div>
<div class="clearfix"></div>
<div class="col-xl-12 col-lg-12 col-12 col-md-12">
    <section class="box ">
        <header class="panel_header">
            <!-- <h2 class="title float-left">Basic Info</h2> -->
            <div class="actions panel_actions float-right">
                <i class="box_toggle fa fa-chevron-down"></i>
                <i class="box_setting fa fa-cog" data-toggle="modal" href="#section-settings"></i>
                <i class="box_close fa fa-times"></i>
            </div>
        </header>
        <div class="content-body">
            <div class="row">
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
                <form method="post" action="{{ route('tickets.update', $ticket->id) }}">
                    @csrf
                    @METHOD('PUT')
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $ticket->title }}" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="5" class="form-control">{{ $ticket->description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priorité (Optional):</label>
                        <select name="priority" id="priority" class="form-control">
                            <option value="">Selectionner Priorité</option>
                            <option value="low" @if($ticket->priority == 'low') {{'selected'}} @endif>Faible</option>
                            <option value="medium" @if($ticket->priority == 'medium') {{'selected'}} @endif>Important</option>
                            <option value="high" @if($ticket->priority == 'high') {{'selected'}} @endif>Urgent</option>
                        </select>
                    </div>


                    <div class="row">
                        <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-5">
                            <label for="tags">Liste des personnes :</label>
                            <select name="from" id="multiselect" class="form-control" multiple="multiple">
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->lastname . ' ' . $user->firstname }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                            <button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="fa fa-forward"></i></button>
                            <button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="fa fa-chevron-right"></i></button>
                            <button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="fa fa-chevron-left"></i></button>
                            <button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="fa fa-backward"></i></button>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                            <label for="multiselect_to">Liste des personnes choisies:</label>
                            <select name="assigned_users[]" id="multiselect_to" class="form-control" size="8" multiple="multiple">
                                @foreach($personnes as $person)
                                <option value="{{ $person->id }}">{{ $person->firstname . ' ' . $person->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>


        </div>
    </section>
</div>
<!-- END CONTENT -->
@endsection