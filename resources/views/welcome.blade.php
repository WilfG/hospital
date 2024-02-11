@extends('layout.index')

@section('content')
<div class="content-body">
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

    <div class="row">

       
        <div class="col-lg-4 col-md-5 col-12">

            <a href="gestion_utilisateur/users" class="db_dynamicbar">
                <div class="r1_graph1 db_box">
                    <span class='bold'>Gestion des utilisateurs</span>
                    <span class='float-right'><small></small></span>
                    <div class="clearfix"></div>
                </div>
            </a>

        </div>
        <div class="col-lg-4 col-md-5 col-12">
            <a href="facturation_gestion_financiere/expenses" class="db_dynamicbar">
                <div class="r1_graph1 db_box">
                    <span class='bold'>Facturation et Gestion Financiere</span>
                    <span class='float-right'><small></small></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
        <!-- <div class="r1_graph2 db_box">
                <span class='bold'>2332</span>
                <span class='float-right'><small>USERS ONLINE</small></span>
                <div class="clearfix"></div>
                <span class="db_linesparkline">Loading...</span>
            </div>


            <div class="r1_graph3 db_box hidden-xs">
                <span class='bold'>342/123</span>
                <span class='float-right'><small>ORDERS / SALES</small></span>
                <div class="clearfix"></div>
                <span class="db_compositebar">Loading...</span>
            </div>

        </div>
        <div class="col-lg-4 col-md-5 col-12">

            <div class="r1_graph1 db_box">
                <span class='bold'>98.95%</span>
                <span class='float-right'><small>SERVER UP</small></span>
                <div class="clearfix"></div>
                <span class="db_dynamicbar">Loading...</span>
            </div>


            <div class="r1_graph2 db_box">
                <span class='bold'>2332</span>
                <span class='float-right'><small>USERS ONLINE</small></span>
                <div class="clearfix"></div>
                <span class="db_linesparkline">Loading...</span>
            </div>


            <div class="r1_graph3 db_box hidden-xs">
                <span class='bold'>342/123</span>
                <span class='float-right'><small>ORDERS / SALES</small></span>
                <div class="clearfix"></div>
                <span class="db_compositebar">Loading...</span>
            </div>

        </div>
        <div class="col-lg-4 col-md-5 col-12">

            <div class="r1_graph1 db_box">
                <span class='bold'>98.95%</span>
                <span class='float-right'><small>SERVER UP</small></span>
                <div class="clearfix"></div>
                <span class="db_dynamicbar">Loading...</span>
            </div>


            <div class="r1_graph2 db_box">
                <span class='bold'>2332</span>
                <span class='float-right'><small>USERS ONLINE</small></span>
                <div class="clearfix"></div>
                <span class="db_linesparkline">Loading...</span>
            </div>


            <div class="r1_graph3 db_box hidden-xs">
                <span class='bold'>342/123</span>
                <span class='float-right'><small>ORDERS / SALES</small></span>
                <div class="clearfix"></div>
                <span class="db_compositebar">Loading...</span>
            </div> -->

    </div>

</div> <!-- End .row -->
</div>
@endsection