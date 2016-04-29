(function(){
	'use strict';

	angular.module('adimovelApp').controller('UsuarioCtrl', Usuario);

	Usuario.injector = ['Request', "URL", "$routeParams"];

	function Usuario(Request, URL, $routeParams) {
		
		var vm = this;

		vm.colunas = [
			{
				value 	: 'nome',
				name 	: 'Nome'	
			},
			{
				value 	: 'email',
				name 	: 'Email'
			},
			{
				value 	: 'status',
				name 	: 'Status'
			},
			{
				value 	: 'tipo_funcionario',
				name 	: 'Tipo'
			}
		];

		active();


		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active() {
			var functions = [getUsuario()];
		}

		function getUsuario() {
			Request.get('usuario').then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});

				vm.usuarios = res[0].objeto;
			});
		}

<<<<<<< Updated upstream
		function getUsuarios(){
			Request.get("usuario").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					//(value.tipo_pessoa == "INQ") ? value.tipo_pessoa = "Inquilino" : value.tipo_pessoa = "Proprietário";

				});
				vm.pessoas = res[0].objeto;
			});
=======
		vm.busca = function(){
			var data = {
				valor : $("#busca").val(),
				coluna: $("#coluna").val()
			}

			Request.set('busca/usuario', data).then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tipo_funcionario == "COR") ? value.tipo_funcionario = "Corretor" : value.tipo_funcionario = "Administrador";
					(value.status == true) ? value.status = "Ativo" : value.status = "Inativo";		
				});
				vm.usuarios = res[0].objeto;
			});

>>>>>>> Stashed changes
		}

		vm.setUsuario = function() {
			
			var data = {
				nm_usuario:  		$("#nome").val(),
				email:   	$("#email").val(),
				nr_cpf: 		$("#cpf").val(),
				senha: 		$("#senha").val(),
				tipo: 		$("#tipo").val(),
				nr_telefone: 	$("#telefone").val()
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
				nm_usuario:  		$("#nome").val(),
				email:   	$("#email").val(),
				nr_cpf: 		$("#cpf").val(),
				senha: 		$("#senha").val(),
				tipo: 		$("#tipo").val(),
				nr_telefone: 	$("#telefone").val()
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
			console.log(id);
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

	}

})();