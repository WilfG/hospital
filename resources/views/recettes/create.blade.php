@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Enregistrement d'une recette</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Home</a>
                </li>
                <li>
                    <a href="hos-patients.html">Dépenses</a>
                </li>
                <li class="active">
                    <strong>Enregistrement d'une recette</strong>
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
                <form action="{{route('recettes.store')}}" method="post"  id="myform" enctype="multipart/form-data">
                    @csrf
                    @METHOD('POST')

                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Libellé</label>
                            <input type="text" name="label" class="form-control" value="{{old('label')}}">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Montant</label>
                            <input type="text" name="cost" class="form-control" value="{{old('cost')}}">
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Enregistrer une nouvelle catégorie de dépense</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('categ_expenses.store')}}" method="post" id="formCategExpPlus">
                    @csrf
                    @METHOD('POST')
                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Libellé de la catégorie</label>
                            <span class="desc"></span>
                            <div class="controls">
                                <input type="text" name="label_categorie" value="{{old('label_categorie')}}" class="form-control" id="label_categorie" required>
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
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-white" data-dismiss="modal">Close</button> -->
                <!-- <button type="button" class="btn btn-default">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
@endsection