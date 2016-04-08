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
        <section>
            <div class="container">
                <div id="panel-master" class="login col-md-8 col-md-offset-2 col-xs-offset-2 col-xs-10">
                <h1 class="text-center">ADI</h1>
                    <div class="panel">
                        <div class="container container-responsive">
                            <form>
                                <div class="material-input">
                                    <label class="float-label">Email</label>
                                    <input class="form-control" type="text">
                                    <span></span>
                                </div>
                                <div class="material-input">
                                    <label class="float-label">Senha</label>
                                    <input class="form-control" type="password">
                                    <span></span>
                                </div>
                                <button id="btn-imovel" class="btn ripple pull-right">Entrar</button>
                            </form>
                        </div> 
                    </div>
                </div>
            </div>
        </section>
    </body>
    <footer>
        {!! HTML::script('bower_components/jquery/dist/jquery.min.js') !!}
        {!! HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
        {!! HTML::script('bower_components/angular/angular.min.js') !!}
        {!! HTML::script('bower_components/angular-route/angular-route.min.js') !!}
        {!! HTML::script('bower_components/Chart.js/Chart.min.js') !!}
        {!! HTML::script('app/app.module.js') !!}
        {!! HTML::script('app/routes.config.js') !!}
        {!! HTML::script('app/Maps/MapCtrl.js') !!}
        {!! HTML::script('app/Grafico/ChartCtrl.js') !!}
        {!! HTML::script('assets/script.js') !!}
        <script type="text/javascript">
            $.ajaxSetup({
               headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
        </script>
    </footer>
</html>
