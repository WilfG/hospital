@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Enregistrement d'un achat</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Accueil</a>
                </li>
                <li>
                    <a href="hos-patients.html">Achats</a>
                </li>
                <li class="active">
                    <strong>Enregistrement d'un achat</strong>
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
                <form action="{{route('purchases.update', $purchase->id)}}" method="post" id="myform" enctype="multipart/form-data">
                    @csrf
                    @METHOD('PUT')
                    <input type="hidden" name="previous_value" value="{{$purchase->quantity}}">
                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">

                        
                        <div class="form-group">
                            <label class="form-label" for="item_type">Type</label>
                            <select name="item_type" class="form-control" id="item_type" required>
                                @if($purchase->type == 'product')
                                    <option value="product" selected>Produit</option>
                                    <option value="material" >Matériel</option>
                                @else
                                    $typeselect = '';
                                    <option value="product" >Produit</option>
                                    <option value="material" selected>Matériel</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group" id="drug_group">
                            <label class="form-label" for="drug">Médicaments</label>
                            <select name="drug" class="form-control selectpicker" data-live-search="true" id="drug">
                                <option value=""></option>
                                @foreach($drugs as $drug)
                                    @php
                                    if($purchase->drug_id == $drug->id){
                                        $prodselect = 'selected';
                                    }else{
                                        $prodselect = '';
                                    }
                                    @endphp
                                <option value="{{$drug->id}}" {{$prodselect}}>{{$drug->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="material_group">
                            <label class="form-label" for="material">Equipements</label>
                            <select name="material" class="form-control selectpicker" data-live-search="true" id="material">
                                <option value=""></option>
                                @foreach($materiels as $materiel)
                                    @php
                                    if($purchase->material_id == $materiel->id){
                                        $matselect = 'selected';
                                    }else{
                                        $matselect = '';
                                    }
                                    @endphp
                                <option value="{{$materiel->id}}" {{$matselect}}>{{$materiel->name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Quantité</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" value="{{$purchase->quantity}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="cost">Prix d'acquisition</label>
                            <input type="number" step="0.1" name="cost" id="cost" class="form-control" value="{{$purchase->cost}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Date d'approvisionnement</label>
                            <input type="date" name="purchase_date" id="purchase_date" class="form-control" value="{{$purchase->purchase_date}}">
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