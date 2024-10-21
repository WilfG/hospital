@extends('layout.index')

@section('content')
<div class="content-body">
    <div class="row">

        <!-- <div class="col-md-2">

            <div id='external-events'>
                <h6 class="font-title"><i class="fa fa-arrows"></i> DRAGGABLE EVENTS</h6>
                <p>Drag into calendar</p>
                <div class='fc-event'>Meeting with Developer Team</div>
                <div class='fc-event'>Office Party</div>
                <div class='fc-event'>March Invoices</div>
                <div class='fc-event'>Call John</div>
                <div class='fc-event'>Dinner with Team</div>
                <div class='fc-event'>Design an iOS App</div>
                <div class='fc-event'>Make a Sandwich</div>
                <div class='fc-event'>Meeting with Customers</div>


            </div>
        </div> -->
        <a href="{{route('appointments.create')}}" class="btn btn-primary" title="Enregistrer un rendez-vous"><i class="fa fa-plus-circle"></i> Enregistrer un Rendez-vous</a>
       <br><br>
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
            <div class="calendar-layout clearfix">

                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection