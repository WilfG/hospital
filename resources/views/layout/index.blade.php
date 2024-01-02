<!DOCTYPE html>
<html class=" ">

@include('layout.head')

<!-- BEGIN BODY -->

<body class=" ">
    @include('layout.header')
    <!-- START CONTAINER -->
    <div class="page-container row-fluid">
        @include('layout.sidebar')

        <!-- START CONTENT -->
        <section id="main-content" class=" ">
            <section class="wrapper" style='margin-top:60px;display:inline-block;width:100%;padding:15px 0 0 15px;'>
                <div class='col-xl-12 col-lg-12 col-md-12 col-12'>
                    <div class="page-title">
                        <div class="float-left">
                            <h1 class="title">Tableau de bord</h1>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="col-lg-12">
                    <section class="box ">
                        @yield('content')
                    </section>
                </div>

            </section>
        </section>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    @include('layout.footer')
</body>

</html>