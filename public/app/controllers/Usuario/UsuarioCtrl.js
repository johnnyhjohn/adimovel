(function(){
	'use strict';

	angular.module('adimovelApp').controller('UsuarioCtrl', Usuario);

	Usuario.injector = ['Request', '$http'];

	function Usuario(Request, $http){
		
		var vm = this;

		active();

		function active(){
			var functions = [getUsuario()];

		}

		function getUsuario(){
			Request.get('usuario').then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tipo_funcionario == "COR") ? value.tipo_funcionario = "Corretor" : value.tipo_funcionario = "Administrador";
					(value.status == true) ? value.status = "Ativo" : value.status = "Inativo";
				
				});

				vm.usuarios = res[0].objeto;
				console.log(vm.usuarios);
			});
		}

		vm.setUsuario = function(){
			
			var data = {
				nome:  		$("#nome").val(),
				email:   	$("#email").val(),
				cpf: 		$("#cpf").val(),
				senha: 		$("#senha").val(),
				tipo: 		$("#tipo").val(),
				telefone: 	$("#telefone").val()
			};

			Request.set('usuario', data).then(function(res){
				console.log(res);
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
	}

})();