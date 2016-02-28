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
    <body data-ng-app="adimovelApp">
        <div id="overlay"></div>
        <ng-include src="'partials/layouts/header.html'"></ng-include>
        <section>
            <div class="container">
                <div id="panel-master" class="col-md-11 col-md-offset-1">
                    <div data-ng-view></div>
                </div>
            </div>
        </section>
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
