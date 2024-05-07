@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Enregistrement d'une consultation</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Accueil</a>
                </li>
                <li>
                    <a href="hos-patients.html">Consultation</a>
                </li>
                <li class="active">
                    <strong>Enregistrement d'une consultaion </strong>
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
                <form action="{{route('consultations.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @METHOD('POST')

                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">
                        <div class="form-group">
                            <label for="patient" class="form-label">Patient</label>
                            <select class="form-control" id="patient" name="patient">
                                <option value="">Choisir le patient...</option>
                                @foreach ($patients as $patient)
                                <option value="{{$patient->id}}">{{$patient->firstname}} {{$patient->lastname}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group">
                            <label class="form-label" for="motif">Motif</label>
                            <input type="text" name="motif" class="form-control" value="{{old('motif')}}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="diagnostic">Diagnostic</label>
                            <textarea name="diagnostic" class="form-control">{{old('diagnostic')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="examens">Examens</label>
                            <textarea name="examens" class="form-control">{{old('examens')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="examens">Ordonnance</label>
                            <textarea name="ordonnance" class="form-control" >{{old('ordonnance')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="traitements">Traitements</label>
                            <textarea name="traitements" class="form-control" >{{old('traitements')}}</textarea>
                        </div>


                        <div class="form-group">
                            <label for="" class="form-label">Etat du paiement</label>
                            <select class="form-control" id="etatpaiement" name="etatpaiement">
                                <option value=""></option>
                                <option value="Payé">Payé</option>
                                <option value="Non Payé">Non Payé</option>
                                <option value="Payé en partie">Payé en partie</option>

                            </select>

                        </div>


                        <div class="form-group">
                            <label class="form-label" for="montant">Montant</label>
                            <input type="numeric" step="0.01" name="montant" class="form-control" value="{{old('montant')}}">
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-9 col-12 padding-bottom-30">
                        <div class="text-left">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </section>
</div>
<!-- END CONTENT -->
@endsection