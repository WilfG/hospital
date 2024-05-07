@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Dossier du patient {{$patient->firstname}} {{$patient->lastname}}</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Accueil</a>
                </li>
                <li>
                    <a href="hos-patients.html">Patients</a>
                </li>
                <li class="active">
                    <strong>Dossier</strong>
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

                <div class="col-md-12 col-lg-12 padding-0">
                    <div class="panel panel-transparent">

                        <!-- <div class="panel-title">
                            Default Tab
                        </div> -->

                        <div class="panel-body">

                            <div role="tabpanel">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs tabcolor5-bg" role="tablist">
                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true" class="active">Informations personnelles</a></li>
                                    <li role="presentation" class=""><a href="#address" aria-controls="address" role="tab" data-toggle="tab" class="" aria-expanded="false">Adresse et contrat</a></li>
                                    <li role="presentation" class=""><a href="#antecedent" aria-controls="antecedent" role="tab" data-toggle="tab" class="" aria-expanded="false">Antécédents</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="home">


                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="lastname">Nom: </label>
                                                <span type="text" name="lastname">{{$patient->lastname}}</span>
                                            </div>

                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="firstname">Prénoms: </label>
                                                <span type="text" name="firstname">{{$patient->firstname}}</span>
                                            </div>

                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="middlename">Autres Prénoms: </label>
                                                <span type="text" name="middlename">{{$patient->middlename}}</span>
                                            </div>

                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="phoneNumber">Téléphone: </label>
                                                <span type="text" name="phoneNumber">{{$patient->phoneNumber}}</span>
                                            </div>

                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="childnumber">Nombre d'enfants: </label>
                                                <span type="number" step="1" name="childnumber">{{$patient->childnumber}}</span>
                                            </div>

                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="height">Taille(cm): </label>
                                                <span type="number" step="1" name="height">{{$patient->height}}</span>
                                            </div>

                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="weight">Poids(kg): </label>
                                                <span type="number" step="1" name="weight">{{$patient->weight}}</span>
                                            </div>

                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="birthdate">Date de naissance: </label>
                                                <span type="date" name="birthdate">{{$patient->birthdate}}</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="occupation">Profession: </label>
                                                <span type="text" name="occupation">{{$patient->occupation}}</span>
                                            </div>
                                        </div>

                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <label for="civility" class="form-label">Civilité: </label>
                                            <span>{{$patient->civility}}</span>
                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <label for="bloodgroup" class="form-label">Groupe sanguin: </label>
                                            <span>{{$patient->bloodgroup}}</span>


                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <label for="maritalStatus" class="form-label">Situation matrimoniale: </label>
                                            @if($patient->maritalStatus == 'Marié')
                                            <span>Marié</span>
                                            @elseif($patient->maritalStatus == 'Célibataire')
                                            <span>Célibataire</span>
                                            @endif

                                        </div>


                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="address">
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="address">Adresse: </label>
                                                <span type="text" name="address">{{$patient->address}}</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label" for="postalcode">Code Postal: </label>
                                                <span type="text" name="postalcode" rows="1" maxlength="6">{{$patient->postalcode}}</span>
                                            </div>
                                        </div>

                                        <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                                            <label for="country" class="form-label">Pays: </label>
                                            @foreach ($countries as $country)
                                            @if($patient->country == $country->id)
                                            @php $selected = 'selected'; @endphp
                                            <span value="{{$country->id}}" {{$selected}}>{{$country->name}}</span>
                                            @endif
                                            @endforeach

                                        </div>
                                        <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                                            <label for="state-dd" class="form-label">Etat / Region: </label>
                                            @foreach ($states as $state)
                                            @if($patient->region == $state->id)

                                            <span value="{{$state->id}}" {{$selected}}>{{$state->name}}</option>
                                                @endif
                                                @endforeach

                                        </div>
                                        <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                                            <label for="city-dd" class="form-label">Ville: </label>
                                            @foreach ($cities as $city)
                                            @if($patient->city == $city->id)
                                            @php $selected = 'selected'; @endphp
                                            <span {{$selected}}>{{$city->name}}</span>
                                            @endif
                                            @endforeach

                                        </div>

                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="antecedent">
                                        <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                            <label for="familydeseases" class="form-label">Antécédents familiaux: </label>
                                            <span id="familydeseases">{{$patient->familydeseases }}</span>
                                        </div>
                                        <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                            <label for="owndeseases" class="form-label">Antécédents personnels: </label>
                                            <span id="owndeseases">{{$patient->owndeseases }} </span>
                                        </div>
                                        <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                            <label for="allergies" class="form-label">Allergies: </label>
                                            <span id="allergies"> {{$patient->allergies }}</span>
                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div>

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="panel">

                        <div class="panel-title">
                            Dossier
                        </div>

                        <div class="panel-body">


                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                                Consultations({{$count_consult}})
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                            <table id="cons-pt" class="datatb display table table-hover table-condensed" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient</th>
                                                        <th>Motif</th>
                                                        <th>Traitements</th>
                                                        <th>Examens</th>
                                                        <th>Diagnostic</th>
                                                        <th>Montant</th>

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($patient->consultations as $consultation)
                                                    <tr>
                                                        <td>#</td>
                                                        <td>{{$consultation->patient->firstname }} {{$consultation->patient->lastname }}</td>
                                                        <td>{{$consultation->motif}}</td>
                                                        <td>{!!$consultation->traitements!!}</td>
                                                        <td>{!!$consultation->diagnostic!!}</td>
                                                        <td>{!!$consultation->examens!!}</td>
                                                        <td>{{$consultation->montant}}</td>
                                                        <!-- <td style="display:flex;"> -->
                                                        <!-- <a href="{{route('consultations.edit', $consultation->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a> -->
                                                        <!-- <a href="{{route('consultations.show', $consultation->id)}}" class="btn btn-primary btn-sm" title="Fiche de stock"><i class="fa fa-eye"></i></a>
                                                            <form action="{{route('consultations.destroy', $consultation->id)}}" method="POST">
                                                                @csrf
                                                                @METHOD('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                                                            </form> -->
                                                        <!-- </td> -->

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Paiements({{$count_paymt}})
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                        <div class="panel-body">
                                            <table id="pmt-pt" class="datatb display table table-hover table-condensed" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Patient</th>
                                                        <th>Type de paiement</th>
                                                        <th>Motif</th>
                                                        <th>Montant</th>
                                                        <!-- <th>Actions</th> -->

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($patient->payments as $payment)

                                                    @foreach($patient->consultations as $consultation)
                                                    @if($consultation->id == $payment->type_id)
                                                    @php
                                                    $motif = $consultation->motif;
                                                    @endphp
                                                    @endif
                                                    @endforeach

                                                    <tr>
                                                        <td>#</td>
                                                        <td>{{$patient->firstname }} {{$patient->lastname }}</td>
                                                        <td>{{$payment->type_paiement}}</td>
                                                        <td>{{$motif}}</td>
                                                        <td>{{$payment->montant}}</td>
                                                        <!-- <td style="display:flex;"> -->
                                                        <!-- <a href="{{route('consultations.edit', $consultation->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a> -->
                                                        <!-- <a href="{{route('consultations.show', $consultation->id)}}" class="btn btn-primary btn-sm" title="Fiche de stock"><i class="fa fa-eye"></i></a>
                                                            <form action="{{route('consultations.destroy', $consultation->id)}}" method="POST">
                                                                @csrf
                                                                @METHOD('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                                                            </form> -->
                                                        <!-- </td> -->

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                Rendez-vous({{$count_rdv}})
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true" style="">
                                        <div class="panel-body">
                                            <table id="rdv-pt" class="datatb display table table-hover table-condensed" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Date de Rendez-vous</th>
                                                        <th>Docteur</th>
                                                        <th>Note</th>
                                                        <!-- <th>Actions</th> -->

                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach($patient->appointments as $apt)

                                                    <tr>
                                                        <td>#</td>
                                                        <td>{{$apt->appointment_time }} </td>
                                                        <td>{{$apt->user->firstname}}</td>
                                                        <td>{!!$apt->notes!!}</td>
                                                       

                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="panel panel-default panel-collapse">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Analyses(0)
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false">
                                        <div class="panel-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div> -->
                            </div>


                        </div>

                    </div>
                </div>
            </div>


        </div>
    </section>
</div>
<!-- END CONTENT -->
@endsection