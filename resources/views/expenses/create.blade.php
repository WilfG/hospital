@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Enregistrement d'une dépense</h1>
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
                    <strong>Enregistrement d'une dépense</strong>
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
                <form action="{{route('expenses.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @METHOD('POST')

                    <input type="hidden" name="reqExpense" value="{{$reqExpense->id}}">
                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">
                        <div class="form-group">
                            <label class="form-label" for="label_categorie">Catégories</label>
                            <span class="desc"></span>
                            <select name="label_categorie" class="form-control" id="label_categorie" required>
                                <option value=""></option>
                                @foreach($categories as $categorie)
                                <option value="{{$categorie->id}}">{{$categorie->label}}</option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="form-group">
                            <label class="form-label" for="reason">justificatif</label>
                            <span class="desc"></span>
                            <div class="controls">
                                <input type="file" name="justificatif"  class="form-control" id="reason" >
                            </div>
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