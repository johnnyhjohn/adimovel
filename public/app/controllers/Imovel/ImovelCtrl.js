(function(){
	'use strict';

	angular.module('adimovelApp').controller('ImovelCtrl', Imovel);

	Imovel.injector = ['Request', "URL", "$routeParams"];

	function Imovel(Request, URL, $routeParams) {
		
		var vm = this;

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
			var functions = [getImovel(), getImoveis()];
		}

		function getImovel(){
			if($routeParams.slug !== undefined){
				Request.get("imoveis/" + $routeParams.slug)
					.then(function(res){
						vm.imovel = res[0].objeto;
				});
			}
		}

		function getImoveis(){
			Request.get("imoveis").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					//(value.tipo_pessoa == "INQ") ? value.tipo_pessoa = "Inquilino" : value.tipo_pessoa = "Proprietário";

				});
				vm.imoveis = res[0].objeto;
			});
		}

		vm.busca = function(){
			var data = {
				valor : $("#busca").val(),
				coluna: $("#coluna").val()
			}

			Request.set('busca/imovel', data).then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					//(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					//(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});
				vm.imoveis = res[0].objeto;
			});

		}

		vm.setImovel = function() {
			var data = {}
			,	date = new Date();

			$("#cadastro-imovel").find('input, textarea, select').each(function(key, value){
				if($(value).attr('id')){
					data[$(value).attr('id')] = $(value).val();
				}
				data['token'] = vm.user.token.token;
				data['dt_cadastrado'] = (date.getFullYear() +"/"+ (date.getMonth() + 1) + "/"+ date.getDate());
			});
			console.log(data);
			Request.set('imoveis', data).then(function(res){
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
				nome:  		$("#nome").val(),
				email:   	$("#email").val(),
				cpf: 		$("#cpf").val(),
				senha: 		$("#senha").val(),
				tipo: 		$("#tipo").val(),
				telefone: 	$("#telefone").val()
			};

			Request.put("imoveis/" + $routeParams.slug, data)
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
			Request.destroy('imoveis/' + id)
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