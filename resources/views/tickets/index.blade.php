@extends('layout.index')

@section('content')

<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <a href="{{route('tickets.create')}}" class="btn btn-primary" title="Créer un ticket"><i class="fa fa-plus-circle"></i>Créer un Ticket</a>
            <br><br>

            <!-- Start Searchbox -->
            <!-- <form class="searchform">
                <input type="text" class="searchbox" id="searchticket" placeholder="Rechercher un ticket">
                <span class="searchbutton"><i class="fa fa-search"></i></span>
            </form> -->
            <!-- End Searchbox -->
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
                        <!-- <th>#</th> -->
                        <th>Libellé</th>
                        <!-- <th>Description</th> -->
                        <th>Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @if (auth()->user()->role_id == 1)
                    @foreach ($tickets as $ticket)
                    <tr>
                        <td>
                            <a href="{{ route('tickets.show', $ticket->id) }}">
                                {{ $ticket->title . "(". $ticket->messages->count() . ")" }}
                            </a>
                            (Administrateur: {{ $ticket->assignedTo->lastname . ' '. $ticket->assignedTo->firstname}}, Assigné à: {{ $ticket->assignedUsers->pluck('firstname')->join(', ') }})

                        </td>
                        <td>
                            <a href="{{route('tickets.edit', $ticket->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    @foreach ($tickets as $ticket)
                    <tr>
                        <td>
                            <a href="{{ route('tickets.show', $ticket->id) }}">
                                {{ $ticket->title }} (Assigné à: {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Non assigné' }})
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection