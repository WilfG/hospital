@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Enregistrement d'une sortie de matériel</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Accueil</a>
                </li>
                <li>
                    <a href="hos-patients.html">Usages</a>
                </li>
                <li class="active">
                    <strong>Enregistrement d'une sortie</strong>
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
                <form action="{{route('usages.store')}}" method="post" id="myform" enctype="multipart/form-data">
                    @csrf
                    @METHOD('POST')
                    <input type="hidden" name="item_type" value="product">
                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">


                        <div class="form-group">
                            <label class="form-label" for="item_type">Matériel</label>

                            <select name="material" class="form-control selectpicker" id="material" data-live-search="true">
                                <option value=""></option>
                                @foreach($materials as $material)
                                <option value="{{$material->id}}">{{$material->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="usage_type">Type de sortie</label>
                            <select name="usage_type" class="form-control selectpicker" id="usage_type" data-live-search="true">
                            <option value=""></option>    
                            <option value="mag"> Sortie de magasin</option>
                                <option value="stock"> Sortie pour usage</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="drug">Quantité</label>
                            <input type="number" name="quantity" id="quantity" min="0" required>
                        </div>
                        <!-- <div class="form-group">
                            <label class="form-label" for="drug">Prix de vente</label>
                            <input type="number" name="sale_price" id="sale_price" required>
                        </div> -->
                        <div class="form-group">
                            <label class="form-label" for="drug">Date de sortie</label>
                            <input type="date" name="sale_date" id="sale_date" required>
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