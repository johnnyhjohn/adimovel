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
    <header>
        <h1 class="title-login">ADI</h1>
    </header>
    <body data-ng-app="adimovelApp">
        <div id="overlay"></div>
        <section>
            <div class="container">
                <div id="panel-master" class="login col-md-8 col-md-offset-2 col-xs-offset-2 col-xs-10">
                    <div class="panel" data-ng-controller='LoginCtrl as vm'>
                        <div class="container container-responsive">                     
                            <form>
                                <div class="material-input">
                                    <label class="float-label">Email</label>
                                    <input class="form-control" type="text" id="email"  name="email">
                                    <span></span>
                                </div>
                                <div class="material-input">
                                    <label class="float-label">Senha</label>
                                    <input class="form-control" type="password" name="password" id="password">
                                    <span></span>
                                </div>
                                <button data-ng-click='vm.login()' class="btn-login btn ripple pull-right">Entrar</button>
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
        {!! HTML::script('bower_components/satellizer/satellizer.js') !!}
        {!! HTML::script('assets/script.js') !!}
        {!! HTML::script('app/app.module.js') !!}
        {!! HTML::script('app/routes.config.js') !!}
        {!! HTML::script('app/services/Service.js') !!}
        {!! HTML::script('app/controllers/Usuario/LoginCtrl.js') !!}
        {!! HTML::script('app/controllers/Usuario/UsuarioCtrl.js') !!}
        {!! HTML::script('app/controllers/Usuario/UsuarioCtrl.js') !!}
        
        <script type="text/javascript">
            $.ajaxSetup({
               headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
        </script>
    </footer>
</html>
