(function(){
	'use strict';

	angular.module('adimovelApp').controller('RelatorioCtrl', Relatorio);

	Relatorio.injector = ["Request", "URL", "$routeParams"];

	function Relatorio(Request, URL, $routeParams){

		var vm = this;
		var user = localStorage.getItem('user');

		if(user){
			vm.user = JSON.parse(user);
		}

		active();

		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active(){
			var functions = [getRelatorioInquilino(), getRelatorioProprietario(), getRelatorioImovel()];
		}
		
		function getRelatorioInquilino(){
			var data = {
				mes 		: $routeParams.mes,
				ano 		: $routeParams.ano
			}

			if($routeParams.slug !== undefined){
				Request.get("relatorios/inquilino/" + $routeParams.slug, data )
					.then(function(res){
						if(res[0].objeto){
							vm.relatoriosinquilino = res[0].objeto;
							vm.movimentacoes = JSON.parse(res[0].objeto[0].movimentacao.movimentacoes);
							console.log(vm.movimentacoes);
						}
				});
			}
		}

		function getRelatorioProprietario(){
			var data = {
				mes 		: $routeParams.mes,
				ano 		: $routeParams.ano
			}

			if($routeParams.slug !== undefined){
				Request.get("relatorios/proprietario/" + $routeParams.slug, data )
					.then(function(res){
						if(res[0].objeto){
							vm.relatoriosproprietario = res[0].objeto;
							
						}
				});
			}
		}

		function getRelatorioImovel(){
			var data = {
				id 		: $("#idimovel").val(),
				ano 	: $routeParams.ano
			}

			if($routeParams.slug !== undefined){
				Request.get("relatorios/imovel/" + $routeParams.slug, data )
					.then(function(res){
						vm.relatoriosimovel = res[0].objeto;
						vm.movimento = [];
						vm.total = 0;
						angular.forEach(vm.relatoriosimovel, function(value, key){
							value.contrato.situacao_pagamento = (value.contrato.situacao_pagamento == true) ? "Pago" : "Pendente"
							vm.movimento[key] = JSON.parse(value.movimentacoes);
							vm.total = parseInt(value.valor) + parseInt(vm.total);
						});
						console.log(vm.relatoriosimovel, vm.movimento);
				});
			}
		}

	}

})();