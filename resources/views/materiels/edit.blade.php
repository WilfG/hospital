@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Modification d'un équipement</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Tableau de bord</a>
                </li>
                <li>
                    <a href="hos-patients.html">Médicaments</a>
                </li>
                <li class="active">
                    <strong>Modification des informations d'un matériel</strong>
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
                <form action="{{route('materiels.update', $materiel->id)}}" method="post" id="myform" enctype="multipart/form-data">
                    @csrf
                    @METHOD('PUT')

                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Libellé du médicament</label>
                            <input type="text" name="name" class="form-control" value="{{$materiel->name}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Description</label>
                            <textarea name="description" class="form-control">{{$materiel->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="currentStock">Stock actuel</label>
                            <input type="number" min="0" name="currentStock" class="form-control" value="{{$materiel->currentStock}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="alertStock">Stock alerte</label>
                            <input type="number" min="0" name="alertStock" class="form-control" value="{{$materiel->alertStock}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="magStock">Stock au magasin</label>
                            <input type="number" min="0" name="magStock" class="form-control" value="{{$materiel->stockMag}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Type de matériel</label>
                            <select name="type_mat" id="type_mat" class="form-control selectpicker" data-live-search="true">
                                @foreach($types as $type)
                                @php
                                if($type->id == $materiel->type_id){
                                $selected = 'selected';
                                }else{
                                $selected = '';
                                }
                                @endphp

                                <option value="{{$type->id}}" selected="{{$selected}}">{{$type->label_type}}</option>
                                @endforeach
                            </select>
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