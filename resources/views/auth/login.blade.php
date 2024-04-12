<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Kode is a Premium Bootstrap Admin Template, It's responsive, clean coded and mobile friendly">
    <meta name="keywords" content="bootstrap, admin, dashboard, flat admin template, responsive," />
    <title>Hopital St Antoine de Padoue</title>

    <!-- ========== Css Files ========== -->
    <link href="{{asset('assets/css/root.css')}}" rel="stylesheet">
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body style="background-image: url({{asset('assets/images/accueil.jpg')}});background-repeat: no-repeat; width:100%;">

    <div class="login-form">
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
        <form name="loginform" id="loginform" action="/login" method="post">
            <div class="top">
                <img src="{{asset('assets/img/logo_st_antoine.png')}}" alt="icon" class="icon">
                <!-- <h1>Kode</h1>
                <h4>Bootstrap Admin Template</h4> -->
            </div>
            @csrf
            @method('POST')
            <div class="form-area">
                <div class="group">
                    <input type="text" name="email" id="user_login" class="form-control" placeholder="Email" />
                    <i class="fa fa-envelope"></i>
                </div>
                <div class="group">
                    <input type="password" name="password" id="user_pass" class="form-control" size="20" placeholder="Mot de passe" />
                    <i class="fa fa-key"></i>
                </div>
                <!-- <div class="group">
                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" class="skin-square-orange" placeholder="Confirmer le Mot de passe" checked>
                    <i class="fa fa-key"></i>
                </div> -->

                <button type="submit" class="btn btn-default btn-block" value="Se Connecter">Se Connecter</button>

        </form>
        <div class="footer-links row">
            <div class="col-xs-6"><a href="#"><i class="fa fa-external-lock"></i> Mot de passe oublie ?</a></div>
            <div class="col-xs-6 text-right"><a href="#"><i class="fa fa-lock"></i> Forgot password</a></div>
        </div>
    </div>
</body>

</html>