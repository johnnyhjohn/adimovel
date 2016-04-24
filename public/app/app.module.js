(function(){
	'use strict';

	angular.module('adimovelApp', ['ngRoute', 'satellizer']);

	var constantes = {
		data 	: window.location.origin + '/data/',
		partials: window.location.origin + '/partials/',
		admin 	: window.location.origin + '/admin/'
	}

	angular.module('adimovelApp').constant('URL', constantes);

	angular.module('adimovelApp').run(Auth);

	Auth.injector = ['$rootScope', '$location', '$window'];

	function Auth($rootScope, $location, $window){
		
		var user = JSON.parse(localStorage.getItem('user'));
		var vm = this;

		if(window.location.pathname.substr(0,6) == '/admin'){
			// $routeChangeStart é disparado quando acontece qualquer mudança de rota
			$rootScope.$on('$routeChangeStart', function(event) {

				// Setamos a variavel `user` com o conteudo do localStorage
				var user = JSON.parse(localStorage.getItem('user'));

				/**
				* 	Se existir dados no localStorage `user` então ele é um usuario
				* 	autenticado, e pode proceguir normalmente.
				* 	Se não for autenticado é redirecionado para a tela de login
				*/
				if(user) {
					/* 	Existindo dados no localStorage adicionamos um atributo
					* 	no $rootScope como 'autenticado' e setamos para true
					*	onde o usuário estará setado como logado
					*/
					$rootScope.autenticado = true;

					// Colocamos os dados do usuario logado no $rootScope
					// Assim conseguindo acessar os dados dele em qualquer
					// Local da nossa aplicação
					$rootScope.currentUser = user;

					if($rootScope.autenticado !== true || $rootScope === undefined) {
					 	event.preventDefault();
					 	$window.location.href = '/admin/login';
					}		
					else{
						$(".showbox").css('display','none');
					}
				}
				if($rootScope.autenticado !== true || $rootScope === undefined) {

					// Se o usuarop não for autenticado, redirecionamos ele
					// para a tela de login
				 	event.preventDefault();
				 	$window.location.href = '/admin/login';
				}
			});
		}
	}

})();