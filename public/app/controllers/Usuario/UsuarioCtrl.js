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
			var functions = [getUsuario(), getUsuarios()];
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
				Request.get("usuario" + $routeParams.slug)
					.then(function(res){
						vm.usuario = res[0].objeto;
				});
			}
		}

		function getUsuarios(){
			Request.get("usuario", vm.user.token).then(function(res){
				console.log(res);
				if(res[0].codigo == "DANGER"){
					var alerta = new alert();
					alerta.danger(res[0].mensagem);
					vm.logout();
					return false;
				}
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";
				});
				vm.usuarios = res[0].objeto;
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
				telefone: 	$("#telefone").val()
			};

			Request.set('usuario', data).then(function(res){
				var alerta = new alert();
				if (res[0].codigo == "SUCCESS") {
					alerta.success(res[0].mensagem);
				} else if (res[0].codigo == "DANGER") {
					alerta = new alert();
					alerta.danger(res[0].mensagem);
				}
				return res;
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
				telefone: 	$("#telefone").val()
			};

			Request.put("usuario/" + $routeParams.slug, data)
				.then(function(res){
					console.log(res, data);
					var alerta = new alert();
					if(res[0].codigo == "SUCCESS"){
						alerta.success(res[0].mensagem);
					}else if(res[0].codigo == "DANGER"){
						alerta = new alert();
						alerta.danger(res[0].mensagem);
					}
					return res;
			});

		}

		vm.deleta = function(){

			var id = event.srcElement.attributes[0].value;
			var tr = $(event.srcElement).closest('tr');

			Request.destroy('usuario/' + id)
				.then(function(res){
					var alerta = new alert();
					if(res[0].codigo == "SUCCESS"){
						alerta.successDeleta(tr, res[0].mensagem);
					}else if(res[0].codigo == "DANGER"){
						alerta = new alert();
						alerta.danger(res[0].mensagem);
					}					
					return res;
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
            window.location.reload();
		}

	}

})();