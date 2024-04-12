@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">

            <a href="{{route('tickets.create')}}" class="btn btn-primary" title="Créer un ticket"><i class="fa fa-plus-circle"></i> Tickets</a>


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

            @if (auth()->user()->role_id == 1)
            <ul>
                @foreach ($tickets as $ticket)
                <li>
                    <a href="{{ route('tickets.show', $ticket->id) }}">
                        {{ $ticket->title }} (Assigné à: {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Non assigné' }})
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <ul>
                @foreach ($tickets as $ticket)
                  <li>
                        <a href="{{ route('tickets.show', $ticket->id) }}">
                            {{ $ticket->title }} (Assigné à: {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Non assigné' }})
                        </a>
                    </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection