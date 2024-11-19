@extends('layout.index')

@section('content')
<!-- START CONTENT -->

<div class='col-xl-12 col-lg-12 col-md-12 col-12'>
    <div class="page-title">

        <div class="float-left">
            <h1 class="title">Enregistrement d'une requête de dépense</h1>
        </div>

        <div class="float-right d-none">
            <ol class="breadcrumb">
                <li>
                    <a href="index.html"><i class="fa fa-home"></i>Home</a>
                </li>
                <li>
                    <a href="hos-patients.html">Requête de Dépenses</a>
                </li>
                <li class="active">
                    <strong>Enregistrement d'une requête de dépense</strong>
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
                <form action="{{route('expenses_requests.store')}}" method="post" id="myform" enctype="multipart/form-data">
                    @csrf
                    @METHOD('POST')
                    <div class="col-xl-8 col-lg-8 col-md-9 col-12">
                       <input type="hidden" name="auteur_id" value="{{auth()->user()->id}}">
                       

                        <div class="form-group">
                            <label class="form-label" for="reason">Motif</label>
                            <span class="desc"></span>
                            <div class="controls">
                                <input type="text" name="reason" value="{{old('reason')}}" class="form-control" id="reason" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="reason">Montant</label>
                            <span class="desc"></span>
                            <div class="controls">
                                <input type="number" min="0" name="amount" value="{{old('amount')}}" class="form-control" id="reason" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="form-label" for="expense_date">Date</label>
                            <!-- <span class="desc">e.g. "04/03/2015"</span> -->
                            <div class="controls">
                                <input type="text" name="expense_date" value="{{old('expense_date')}}" class="form-control datepicker" data-format="yyyy-mm-dd" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="note">Note</label>
                            <!-- <span class="desc">e.g. "04/03/2015"</span> -->
                            <div class="controls">
                                <textarea name="note" id="note" class="form-control" data-format="yyyy-mm-dd">{{old('note')}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="justificatif_req">justificatif de la requête</label>
                            <span class="desc"></span>
                            <div class="controls">
                                <input type="file" name="justificatif_req" class="form-control" id="justificatif_req">
                            </div>
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