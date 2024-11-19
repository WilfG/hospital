@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Approvisionnement matériels</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Accueil</a>
                </li>
                <li>
                    <a href="hos-patients.html">Gestion du stock</a>
                </li>
                <li class="active">
                    <strong>Approvisionnement matériels</strong>
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
                <form action="{{route('purchases_mat.store')}}" method="post" id="myform" enctype="multipart/form-data">
                    @csrf
                    @METHOD('POST')

                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">


                        <div class="form-group">
                            <label class="form-label" for="usage_type">Type d'approvisionnement</label>
                            <select name="usage_type" class="form-control selectpicker" id="usage_type" data-live-search="true">
                                <option value=""></option>
                                <option value="mag"> Pour magasin</option>
                                <option value="stock"> Pour centre</option>
                            </select>
                        </div>

                        <div class="form-group" id="">
                            <label class="form-label" for="material">Equipements</label>
                            <select name="material" class="form-control selectpicker" data-live-search="true" id="">
                                <option value=""></option>
                                @foreach($materiels as $materiel)
                                <option value="{{$materiel->id}}">{{$materiel->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Quantité</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{old('quantity')}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cost">Prix d'acquisition</label>
                            <input type="number" step="0.1" name="cost" id="cost" class="form-control" value="{{old('cost')}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Date d'approvisionnement</label>
                            <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="{{old('movement_date')}}">
                        </div>


                    </div>

                    <div class="col-xl-8 col-lg-8 col-md-9 col-12 padding-bottom-30">
                        <div class="text-left">
                            <button type="submit" class="btn btn-primary" id="submit">Enregistrer</button>
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </section>
</div>
<!-- END CONTENT -->
@endsection