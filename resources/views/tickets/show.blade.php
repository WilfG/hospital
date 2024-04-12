@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Détails du ticket</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="/"><i class="fa fa-home"></i>Accueil</a>
                </li>
                <li>
                    <a href="{{route('tickets.index')}}">Ticket</a>
                </li>
                <li class="active">
                    <strong>Détails du ticket</strong>
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
                <p><b>Titre:</b> {{ $ticket->title }}</p>
                <p><b>Description:</b> {{ $ticket->description }}</p>
                <p><b>Statut:</b> @if($ticket->status == 'open') {{'ouvert'}} @else {{'Ce sujet est déjà fermé'}} @endif</p>
                <p><b>Priorité:</b> @if($ticket->priority == 'high') {{'élevé'}} @elseif($ticket->priority == 'medium') {{'moyen'}} @elseif($ticket->priority == 'low') {{'faible'}} @endif</p>
                <p><b>Créé par:</b> {{ $ticket->user->lastname.' '.$ticket->user->firstname  }}</p>
                <p><b>Assigné à:</b> {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Non assigné' }}</p>

                <h2>Messages</h2>

                <ul>
                    @foreach ($messages as $message)
                    <li>{{ $message->user->lastname .' '.$message->user->firstname }} ({{ $message->created_at->format('Y-m-d H:i:s') }}): {!! $message->content !!}</li>
                    @endforeach
                </ul>

                <h2>Ajouter un Message</h2>
                <form method="POST" action="{{ route('tickets.add_message', $ticket->id) }}">
                    @csrf

                    <div class="form-group">
                        <label for="content">contenu:</label>
                        
                        <textarea name="content" id="content" rows="5" class="form-control tinymce-editor"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Envoyer le message</button>
                </form>
            </div>


        </div>
    </section>
</div>

<!-- END CONTENT -->
@endsection