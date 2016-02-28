<!doctype html>
<html lang="pt_br">
    <head>
        <base href="/">
        <meta charset="UTF-8">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <title>AdImovel</title>
        {!! HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
        {!! HTML::style('bower_components/font-awesome/css/font-awesome.css') !!}
        {!! HTML::style('assets/style.css') !!}
    </head>
 <body>
        <div id="overlay"></div>
        <header>
            <div class="admin">
                <p class="pull-right">
                    Olá Usuario 
                    {!! HTML::image('image/no-image.png', 'Avatar' ,array('class' => 'avatar-admin')) !!}   
                </p>
                <div class="user-info">
                    <div class="info-content">
                        <div class="avatar">
                            {!! HTML::image('image/no-image.png', 'Avatar' ,array('class' => 'avatar')) !!}   
                        </div>
                        <div class="info">
                            <h3>Usuario</h3>
                            <p>email@gmail.com</p>
                            <p class="editar-perfil-btn"><a href="{{ url('/editar-perfil') }}">Editar Perfil</a></p>
                        </div>
                    </div>
                    <div class="info-footer">
                        <a href="{{ url('/sair') }}">Sair</a>
                    </div>    
                </div>
            </div>
                <div class="container user-header">
                    <h1 class="text-left"><a href="{{ url('/') }}">ADImovel</a></h1>
                    <!-- <img class="avatar" src=" }}">
                    <p class="header-name">}</p> -->
                </div>
                <nav class="nav navbar-default">
                    <div class="navbar">
                        <ul class="menu-ul">
                            <li class="active"><a href=""><i class="fa fa-dashboard fa-2x"></i>Dashboard</a></li>
                            <li><a href=""><i class="fa fa-home fa-2x"></i>Imóveis</a></li>
                            <li><a href=""><i class="fa fa-users fa-2x"></i>Pessoas</a></li>
                            <li><a href=""><i class="fa fa-users fa-2x"></i>Usuários</a></li>
                            <li><a href=""><i class="fa fa-file-text fa-2x"></i>Relatórios</a></li>
                        </ul>
                    </div>
                </nav>
            <button type="button" class="navbar-toggle menu show" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span id="icon-bar1" class="icon-bar"></span>
                <span id="icon-bar2" class="icon-bar"></span>
                <span id="icon-bar3" class="icon-bar"></span>
            </button>
            </div>
        </header>
            <section data-ng-app="adimovelApp">
                <div class="container">
                    <div id="panel-master" class="col-md-11 col-md-offset-1">
                        <div data-ng-view></div>
                    </div>
                </div>
            </section>
                   
                </div>
        </body>
        <footer>
            {!! HTML::script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBCAKUTbamk1pEER1vty-_nB2UHYKnO37Y&libraries=places') !!}
            {!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
            {!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
            {!! HTML::script('bower_components/angular/angular.min.js') !!}
            {!! HTML::script('bower_components/angular-route/angular-route.min.js') !!}
            {!! HTML::script('app/app.module.js') !!}
            {!! HTML::script('app/routes.config.js') !!}
            {!! HTML::script('app/Maps/MapCtrl.js') !!}
            {!! HTML::script('assets/script.js') !!}
            <script type="text/javascript">
            $.ajaxSetup({
               headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
            </script>
            
        </footer>
    </html>
