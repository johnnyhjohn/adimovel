(function(){
	'use strict';

	angular.module('adimovelApp').controller('AdministrarCtrl', Administrar);

	Administrar.injector = ["Request", "URL", "$routeParams"];

	function Administrar(Request, URL, $routeParams){

		var vm = this;
		var user = localStorage.getItem('user');

		if(user){
			vm.user = JSON.parse(user);
		}

		vm.colunas = [
			{
				value 	: 'imovel',
				name : 'Imovel'	
			},
			{
				value 	: 'proprietario',
				name : 'Proprietario'
			},
			{
				value 	: 'inquilino',
				name : 'Inquilino'
			},
			{
				value 	: 'nr_contrato',
				name : 'Numero Contrato'
			},
			{
				value 	: 'finalidade',
				name : 'Finalidade'
			}
		];


		active();

		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active(){
			var functions = [getMovimentos(), getMovimento()];
		}

		vm.setMovimento = function(){
			var data = {
				imovel 	 		: $("#imovel").val(),
				proprietario 	: $("#proprietario").val(),
				inquilino 		: $("#inquilino").val(),
				nr_contrato 	: $("#nr_contrato").val(),
				dt_inicio 		: $("#dt_inicio").val(),
				dt_vencimento 	: $("#dt_vencimento").val(),
				valor 	 		: $("#valor").val(),
				situacao 	 	: $("#situacao").val(),
				finalidade 	 	: $("#finalidade").val()
			}
			Request.set("administrar", data).then(function(res){
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

		vm.update = function(){
			var data = {
				imovel 	 		: $("#imovel").val(),
				proprietario 	: $("#proprietario").val(),
				inquilino 		: $("#inquilino").val(),
				nr_contrato 	: $("#nr_contrato").val(),
				dt_inicio 		: $("#dt_inicio").val(),
				dt_vencimento 	: $("#dt_vencimento").val(),
				valor 	 		: $("#valor").val(),
				situacao 	 	: $("#situacao").val(),
				finalidade 	 	: $("#finalidade").val(),
				ativo 			: $("#ativo").val()
			};

			Request.put("administrar/" + $routeParams.slug, data)
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
			Request.destroy('administrar/' + id)
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

		vm.busca = function(){
			var data = {
				valor : $("#busca").val(),
				coluna: $("#coluna").val()
			}

			Request.set('busca/administrar', data).then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					(value.finalidade == "VEN") ? value.finalidade = "Venda" : value.finalidade = "Alugar";
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";
				});
				vm.movimentos = res[0].objeto;
			});

		}

		function getMovimentos(){
			Request.get("administrar").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.finalidade == "VEN") ? value.finalidade = "Venda" : value.finalidade = "Aluguel";
					(value.situacao_pagamento == true) ? value.situacao_pagamento = "Pago" : value.situacao_pagamento = "Pendente";
				});
				console.log(res);
				vm.movimentos = res[0].objeto;
			});
		}

		function getMovimento(){
			if($routeParams.slug !== undefined){
				Request.get("administrar/" + $routeParams.slug)
					.then(function(res){
						vm.movimento = res[0].objeto;
				});
			}
		}
	}

})();