(function(){
	'use strict';

	angular.module('adimovelApp').controller('UsuarioCtrl', Usuario);

	Usuario.injector = ['Request', "URL", "$routeParams", "$rootScope"];

	function Usuario(Request, URL, $routeParams, $rootScope) {
		
		var vm = this;
		var user = localStorage.getItem('user');

		if(user){
			vm.user = JSON.parse(user);
		}

		vm.colunas = [
			{
				value 	: 'nm_usuario',
				name 	: 'Nome'	
			},
			{
				value 	: 'email',
				name 	: 'Email'
			},
			{
				value 	: 'ativo',
				name 	: 'Status'
			},
			{
				value 	: 'tp_funcionario',
				name 	: 'Tipo'
			}
		];

		active();


		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active() {
			var functions = [getUsuario(), getUsuarios(), getCorretor()];
		}

		function getUsuario2() {
			Request.get('usuario').then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});

				vm.usuario = res[0].objeto;
				console.log(vm.usuario);
			});
		}

		function getUsuario(){
			if($routeParams.slug !== undefined){
				Request.get("usuario/" + $routeParams.slug, vm.user.token)
					.then(function(res){
						vm.usuario = res[0].objeto;
				});
			}
		}

		
		function getPerfil(){
			Request.get("usuario/perfil", vm.user.token)
				.then(function(res){
					vm.usuario = res[0].objeto;
			});
		}

		function getUsuarios(){

			if($routeParams.perfil == 'perfil'){
				getPerfil();
				return false;
			}

			if($routeParams.slug) return false;

			Request.get("usuario", vm.user.token).then(function(res){
				
				if( res[0] ){
					if(res[0].codigo == "DANGER"){
						var alerta = new alert();
						alerta.danger(res[0].mensagem);
						//vm.logout();
						return false;
					}
				} else{
					$(".msg-retorno").html('Problemas internos, contato o Administrador.');
					return false;
				}
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";
				});
				vm.usuarios = res[0].objeto;
			});
		}

		function getCorretor(){
			Request.get("usuario/corretor").then(function(res){
				if(res[0].codigo == "DANGER"){
					var alerta = new alert();
					alerta.danger(res[0].mensagem);
					return false;
				}

				vm.corretores = res[0].objeto;
			});
		}

		vm.busca = function(){
			var data = {
				valor : $("#busca").val(),
				coluna: $("#coluna").val()
			}

			Request.set('busca/usuario', data).then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});
				vm.usuarios = res[0].objeto;
			});

		}

		vm.setUsuario = function() {
			
			var data = {
				token: 		vm.user.token.token,
				nome:  		$("#nome").val(),
				email:   	$("#email").val(),
				cpf: 		$("#cpf").val(),
				senha: 		$("#senha").val(),
				tipo: 		$("#tipo").val(),
				telefone: 	$("#telefone").val(),
				imagem_thumb :$("#img_prev").attr('src')
			};

			Request.set('usuario', data).then(function(res){
				var alerta = new alert();

				if (res[0].codigo == "SUCCESS") {
					alerta.success(res[0].mensagem);
				} else if (res[0].codigo == "DANGER") {
					
					$(".msg-retorno").html(res[0].objeto);
					
					alerta = new alert();
					alerta.danger(res[0].mensagem);
				}
			});	
		}

		vm.update = function(){
			var data = {
				token: 		vm.user.token.token,
				nome:  		$("#nome").val(),
				email:   	$("#email").val(),
				cpf: 		$("#cpf").val(),
				senha: 		$("#senha").val(),
				tipo: 		$("#tipo").val(),
				telefone: 	$("#telefone").val(),
				imagem_thumb :$("#img_prev").attr('src')
			};

			Request.put("usuario/" + $routeParams.slug, data)
				.then(function(res){
					var alerta = new alert();

					if(res[0].codigo == "SUCCESS"){
						alerta.success(res[0].mensagem);
						console.log($rootScope.currentUser);
						$rootScope.currentUser.foto 		= res[0].objeto.foto;
						$rootScope.currentUser.nm_usuario 	= res[0].objeto.nm_usuario;
						$rootScope.currentUser.email 		= res[0].objeto.email;
						console.log($rootScope.currentUser);
					}else if(res[0].codigo == "DANGER"){
						
						$(".msg-retorno").html(res[0].objeto);

						alerta = new alert();
						alerta.danger(res[0].mensagem);
					}
			});

		}

		vm.deleta = function(){

			var id = event.srcElement.attributes[0].value;
			var tr = $(event.srcElement).closest('tr');

			Request.destroy('usuario/' + id)
				.then(function(res){
					var alerta = new alert();
					if(res[0]){
						if(res[0].codigo == "SUCCESS"){
							alerta.successDeleta(tr, res[0].mensagem);
						}else if(res[0].codigo == "DANGER"){
							alerta = new alert();
							alerta.danger(res[0].mensagem);
						}					
						return res;
					} else{
						$(".msg-retorno").html('Problemas internos, contato o Administrador.');
						return res;
					}
			})
		}
		vm.logout = function(){
			// Limpa o localStorage
            localStorage.removeItem('user');
            // Muda a propriedade autenticado para false
            // Para assim mostrar que não tem mais usuario logado
            $rootScope.autenticado = false;
            // Remove os dados da propriedade currentUser
            $rootScope.currentUser = null;           
            // Redireciona para a tela de login do sistema
            event.preventDefault();
            //window.location.reload();
		}

		vm.uploadImagem = function(){

		}

	}

})();