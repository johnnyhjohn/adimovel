<!doctype html>
<html lang="pt_br" >
    <head>
        <base href="/">
        <meta charset="UTF-8">
        <meta name="_token" content="{!! csrf_token() !!}"/>
        <title>AdImovel</title>
        {!! HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
        {!! HTML::style('bower_components/font-awesome/css/font-awesome.css') !!}
        {!! HTML::style('assets/style.css') !!}
    </head>
<div class="showbox">
  <div class="loader">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
  </div>
</div>
    <body data-ng-app="adimovelApp">
        <div id="overlay"></div>
        <ng-include src="'partials/layouts/header.html'"></ng-include>
        <section>
            <div class="container">
                <div id="panel-master" class="col-md-11 col-md-offset-1 col-xs-offset-1 col-xs-11">
                    <div data-ng-view></div>
                </div>
            </div>
        </section>
    </body>
    <footer>
        {!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
        {!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
        {!! HTML::script('bower_components/angular/angular.min.js') !!}
        {!! HTML::script('bower_components/angular-route/angular-route.min.js') !!}
        {!! HTML::script('bower_components//satellizer/satellizer.js') !!}
        {!! HTML::script('bower_components/Chart.js/Chart.min.js') !!}
        {!! HTML::script('assets/script.js') !!}
        {!! HTML::script('app/app.module.js') !!}
        {!! HTML::script('app/routes.config.js') !!}
        {!! HTML::script('app/services/Service.js') !!}
        {!! HTML::script('app/controllers/Administrar/AdministrarCtrl.js') !!}
        {!! HTML::script('app/controllers/Imovel/ImovelCtrl.js') !!}
        {!! HTML::script('app/controllers/TipoImovel/TipoImovelCtrl.js') !!}
        {!! HTML::script('app/controllers/Pessoa/PessoaCtrl.js') !!}
        {!! HTML::script('app/controllers/Usuario/UsuarioCtrl.js') !!}
        {!! HTML::script('app/controllers/Usuario/LoginCtrl.js') !!}
        {!! HTML::script('app/controllers/Maps/MapCtrl.js') !!}
        {!! HTML::script('app/controllers/Grafico/ChartCtrl.js') !!}
        <div class="map"></div>
        <script type="text/javascript">
            $.ajaxSetup({
               headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
        </script>
    </footer>
</html>
