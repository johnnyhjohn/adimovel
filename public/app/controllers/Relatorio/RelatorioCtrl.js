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
			var functions = [getRelatorioInquilino(), getRelatorioProprietario()];
		}

		function getRelatorioInquilino(){
			var data = {
				mes 		: $routeParams.mes,
				ano 		: $routeParams.ano
			}

			if($routeParams.slug !== undefined){
				Request.get("relatorios/inquilino/" + $routeParams.slug, data )
					.then(function(res){
						vm.relatoriosinquilino = res[0].objeto;
						console.log(vm.relatoriosinquilino);
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
						vm.relatoriosproprietario = res[0].objeto;
				});
			}
		}

		

	}

})();