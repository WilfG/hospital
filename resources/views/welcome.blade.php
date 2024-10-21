@extends('layout.index')

@section('content')
<div class="content-body">
    Filtrer les ventes
    <div class="row">
        <div class="panel-body">
            <!-- Tab panes -->
            <form action="" id="formSalesFilter" method="post" enctype="multipart/form-data">
                @csrf
                @METHOD('POST')
                <div class="tab-content">

                    <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="dateFrom">Date de début</label>
                            <input type="date" name="dateFrom" id="dateFrom" class="form-control" value="{{old('dateFrom')}}">
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-4 col-md-4 col-12">
                        <div class="form-group">
                            <label class="form-label" for="dateTo">Date de fin</label>
                            <input type="date" name="dateTo" id="dateTo" class="form-control" value="{{old('dateTo')}}">
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-12 ">
                        <div class="text-left">
                            <br>
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>



    </div>
    <div class="row" id="salesTable">
        <table border="1" id="resultSales" class="display table table-hover table-condensed" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produits</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="salesTableBody">
                <!-- Table rows will be inserted here dynamically -->
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td colspan="2" id="totalSalePrice"><strong>0</strong></td>
                </tr>
            </tfoot>
        </table>

    </div>
</div>
<hr style="background: red;">
<div class="content-body">

    <!-- Start Top Stats -->
    <div class="col-md-12">
        <ul class="topstats clearfix">
            <li class="arrow"></li>
            <li class="col-xs-6 col-lg-4">
                <span class="title"><i class="fa fa-dot-circle-o"></i> Ventes du jour</span>
                <h3>{{$totDaySales}}</h3>
                <span class="diff"><b class="color-down"><i class="fa fa-caret-down"></i> FCFA%</b> Aujourd'hui</span>
            </li>
            <li class="col-xs-6 col-lg-4">
                <span class="title"><i class="fa fa-calendar-o"></i> Vente du mois</span>
                <h3>{{$totMonthSales}}</h3>
                <span class="diff"><b class="color-up"><i class="fa fa-caret-up"></i> FCFA</b> Ce mois seulement</span>
            </li>
            <li class="col-xs-6 col-lg-4">
                <span class="title"><i class="fa fa-shopping-cart"></i> Tot. Patients mois</span>
                <h3 class="color-up">{{$totCurrentMthPatients}}</h3>
                <span class="diff"><b class="color-up"><i class="fa fa-caret-up"></i> Ce mois seulement</b> </span>
            </li>
            <!-- <li class="col-xs-6 col-lg-2">
                        <span class="title"><i class="fa fa-users"></i> Visitors</span>
                        <h3>960</h3>
                        <span class="diff"><b class="color-down"><i class="fa fa-caret-down"></i> 26%</b> from yesterday</span>
                    </li>
                    <li class="col-xs-6 col-lg-2">
                        <span class="title"><i class="fa fa-eye"></i> Page View</span>
                        <h3 class="color-up">46.230</h3>
                        <span class="diff"><b class="color-down"><i class="fa fa-caret-down"></i> 26%</b> from yesterday</span>
                    </li>
                    <li class="col-xs-6 col-lg-2">
                        <span class="title"><i class="fa fa-clock-o"></i> Avarage Time</span>
                        <h3 class="color-down">2:10<small>min</small></h3>
                        <span class="diff"><b class="color-up"><i class="fa fa-caret-up"></i> 26%</b> from last week</span>
                    </li> -->
        </ul>
    </div>
    <!-- End Top Stats -->

    @if (session('errors'))
    <div class="mb-4 font-medium text-sm text-green-600 alert alert-danger">
        {{ session('errors') }}
    </div>
    @endif
    @if (session('success'))
    <div class="mb-4 font-medium text-sm text-green-600 alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    <h2>Les produits en rupture de stock</h2>
    <table id="example-11" class="display table table-hover table-condensed datatb" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Libellé</th>
                <th>Disponible en stock</th>
                <!-- <th>Actions</th> -->

            </tr>
        </thead>

        <tbody>
            @foreach($outStockProds as $drug)
            <tr>
                <td style="background: red; color:white">#</td>
                <td style="background: red; color:white">{{$drug->name}}</td>
                <td style="background:red; color:white">{{$drug->currentStock}}</td>
                <!-- <td style="display:flex;">
                    <a href="{{route('drugs.edit', $drug->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                    
                    <a href="{{route('drugs.show', $drug->id)}}" class="btn btn-primary btn-sm" title="Dossier"><i class="fa fa-eye"></i></a>
                </td> -->

            </tr>
            @endforeach
        </tbody>
    </table><br>
    <h2>Les 5 derniers patients enregistrés</h2>

    <table id="example-11" class="display table table-hover table-condensed datatb" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Prénoms</th>
                <th>Nom</th>
                <th>Actions</th>

            </tr>
        </thead>

        <tbody>
            @foreach($fiveLastpatients as $patient)
            <tr>
                <td>#</td>
                <td>{{$patient->firstname}}</td>
                <td>{{$patient->lastname}}</td>
                <td style="display:flex;">
                    <a href="{{route('patients.edit', $patient->id)}}" class="btn btn-warning btn-sm" style="margin: 2px;"><i class="fa fa-pencil" title="Modifier"></i></a>
                    <!-- <form action="{{route('patients.destroy', $patient->id)}}" method="POST">
                        @csrf
                        @METHOD('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer"><i class="fa fa-trash"></i></button>
                    </form> -->
                    <a href="{{route('patients.show', $patient->id)}}" class="btn btn-primary btn-sm" title="Dossier"><i class="fa fa-eye"></i></a>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div> <!-- End .row -->

@endsection