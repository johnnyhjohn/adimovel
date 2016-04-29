(function(){
	'use strict';

	angular.module('adimovelApp').controller('LoginCtrl', Login);

	Login.injector = ['Request', '$auth', '$rootScope', '$location', '$window'];


    function Login(Request, $auth, $rootScope, $location, $window) {

        var vm = this;

        vm.users;
        vm.error;

        vm.getUsers = function() {

            // Pega lista de usuarios
            Request.get('data/authenticate').then(function(users) {
                vm.users = users;
            },function(error) {
                vm.error = error;
            });
        }

		vm.login = function() {

            var credentials = {
                email: 		$("#email").val(),
                password: 	$("#password").val()
            }
			
			// Request para conseguir o token do usuario
			// Retorna ou o token, ou uma mensagem de erro
            Request.set('authenticate', credentials).then(function(res){
            	vm.token = res;
                // Se tiver erro, mostra a mensagem de erro
                // E não efetua login
                if (res.erro) {
					var alerta = new alert();
					alerta.danger(res.erro);
                	return false;
                }
                // Se não possuir erro, fazemos uma requisição post com o token
                Request.set('authenticate/user', vm.token).then(function(response){

                	// Se a resposta não for `undefined` setaremos o localStorage
                	if (response) {
	                	// Stringify os dados de retorno
	               	 	// para preparar para o localStorage
	               	 	console.log(response.user.admin);
	               	 	if(response.user.admin == false){
	               	 		delete response.user.admin;	
	               	 	}
	               	 	console.log(response.user.admin);
		                var user = JSON.stringify(response.user);
		                
		                // Setamos os dados com Stringify no localStorage
		                localStorage.setItem('user', user);

		                // A propriedade autenticado é setado como true
		                // Para mostrar que o usuario esta logado 
		                $rootScope.autenticado = true;

						// Colocamos os dados do usuario logado no $rootScope
						// Assim conseguindo acessar os dados dele em qualquer
						// Local da nossa aplicação
		                $rootScope.currentUser = response.user;

		                // Então redirecionamos o usuario para 
		                // A dashboard do sistema
		                event.preventDefault();
					 	$window.location.href = '/admin';  
				 	}         	
                });
            }, function(error) {
                vm.loginError = true;
                vm.loginErrorText = error.data.error;
            });
        }        

        vm.logout = function() {

            $auth.logout().then(function() {

                // Limpa o localStorage
                localStorage.removeItem('user');

                // Muda a propriedade autenticado para false
                // Para assim mostrar que não tem mais usuario logado
                $rootScope.autenticado = false;

                // Remove os dados da propriedade currentUser
                $rootScope.currentUser = null;           

                // Redireciona para a tela de login do sistema
                event.preventDefault();
			 	$window.location.href = '/admin/login';  
            });
        }
    }	


})();