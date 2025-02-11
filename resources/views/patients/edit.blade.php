@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Modification des informations d'un patient</h1>
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
                    <strong>Modification d'un patients</strong>
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
                                <form action="{{route('patients.update', $patient->id)}}" method="post" id="myform" enctype="multipart/form-data">
                                    @csrf
                                    @METHOD('PUT')
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home">


                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="lastname">Nom</label><span class="text-danger"> *</span>
                                                    <input type="text" name="lastname" class="form-control" value="{{$patient->lastname}}" required>
                                                </div>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="firstname">Prénoms</label><span class="text-danger"> *</span>
                                                    <input type="text" name="firstname" class="form-control" value="{{$patient->firstname}}" required>
                                                </div>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="middlename">Autres Prénoms</label>
                                                    <input type="text" name="middlename" class="form-control" value="{{$patient->middlename}}">
                                                </div>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="phoneNumber">Téléphone</label>
                                                    <input type="text" name="phoneNumber" class="form-control" value="{{$patient->phoneNumber}}">
                                                </div>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="childnumber">Nombre d'enfants</label>
                                                    <input type="number" step="1" name="childnumber" class="form-control" value="{{$patient->childnumber}}">
                                                </div>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="height">Taille(cm)</label>
                                                    <input type="number" step="1" name="height" class="form-control" value="{{$patient->height}}">
                                                </div>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="weight">Poids(kg)</label>
                                                    <input type="number" step="1" name="weight" class="form-control" value="{{$patient->weight}}">
                                                </div>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="birthdate">Date de naissance</label>
                                                    <input type="date" name="birthdate" class="form-control" value="{{$patient->birthdate}}">
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="occupation">Profession</label>
                                                    <input type="text" name="occupation" class="form-control" value="{{$patient->occupation}}">
                                                </div>
                                            </div>

                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <label for="civility" class="form-label">Civilité</label>
                                                <select class="form-control" id="civility" name="civility">
                                                    <option value="M">M.</option>
                                                    <option value="Mlle">Mlle</option>
                                                    <option value="Mme">Mme</option>

                                                </select>
                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <label for="bloodgroup" class="form-label">Groupe sanguin</label>
                                                <select class="form-control" id="bloodgroup" name="bloodgroup">
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>

                                                </select>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <label for="maritalStatus" class="form-label">Situation matrimoniale</label>
                                                <select class="form-control" id="maritalStatus" name="maritalStatus">
                                                    <option value=""></option>
                                                    @if($patient->maritalStatus == 'Marié')
                                                    <option value="Marié" selected>Marié</option>
                                                    <option value="Célibataire">Célibataire</option>
                                                    @elseif($patient->maritalStatus == 'Célibataire')
                                                    <option value="Marié">Marié</option>
                                                    <option value="Célibataire" selected>Célibataire</option>
                                                    @else
                                                    <option value="Marié">Marié</option>
                                                    <option value="Célibataire" >Célibataire</option>
                                                    @endif
                                                </select>

                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="childnumber">Photo</label>
                                                    <input type="file" name="photo" class="form-control">
                                                </div>

                                            </div>


                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="address">
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="address">Adresse</label>
                                                    <input type="text" name="address" class="form-control" value="{{$patient->address}}" />
                                                </div>
                                            </div>
                                            <div class="col-xl-8 col-lg-6 col-md-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="postalcode">Code Postal</label>
                                                    <input type="text" name="postalcode" rows="1" maxlength="6" class="form-control" value="{{$patient->postalcode}}" />
                                                </div>
                                            </div>

                                            <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                                                <label for="country" class="form-label">Pays</label>
                                                <select class="form-control" id="country" name="country">
                                                    @foreach ($countries as $country)
                                                    @if($patient->country == $country->id)
                                                    @php $selected = 'selected'; @endphp
                                                    @else
                                                    @php $selected = ''; @endphp
                                                    @endif
                                                    <option value="{{$country->id}}" {{$selected}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                                                <label for="state-dd" class="form-label">Etat / Region</label>
                                                <select class="form-control" id="state-dd" name="region">
                                                    <option value=""></option>
                                                    @foreach ($states as $state)
                                                    @if($patient->region == $state->id)
                                                    @php $selected = 'selected'; @endphp
                                                    @else
                                                    @php $selected = ''; @endphp
                                                    @endif
                                                    <option value="{{$state->id}}" {{$selected}}>{{$state->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                                                <label for="city-dd" class="form-label">Ville</label>
                                                <select class="form-control" id="city-dd" name="city">
                                                    <option value=""></option>
                                                    @foreach ($cities as $city)
                                                    @if($patient->city == $city->id)
                                                    @php $selected = 'selected'; @endphp
                                                    @else
                                                    @php $selected = ''; @endphp
                                                    @endif
                                                    <option value="{{$city->id}}" {{$selected}}>{{$city->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="antecedent">
                                            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                                <label for="familydeseases" class="form-label">Antécédents familiaux: </label>
                                                <input class="form-control" id="familydeseases" name="familydeseases" value="{{$patient->familydeseases }}" />
                                            </div>
                                            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                                <label for="owndeseases" class="form-label">Antécédents personnels: </label>
                                                <input class="form-control" id="owndeseases" name="owndeseases" value="{{$patient->owndeseases }}" />
                                            </div>
                                            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                                                <label for="allergies" class="form-label">Allergies: </label>
                                                <input class="form-control" id="allergies" name="allergies" value="{{$patient->allergies }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-8 col-lg-8 col-md-9 col-12 padding-bottom-30">
                                        <div class="text-left">
                                            <button type="submit" class="btn btn-primary"  id="submit">Enregistrer</button>
                                        </div>
                                    </div>
                                </form>

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