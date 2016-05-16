(function(){
	'use strict';

	angular.module('adimovelApp').controller('TipoImovelCtrl', TipoImovel);

	TipoImovel.injector = ['Request', "URL", "$routeParams"];

	function TipoImovel(Request, URL, $routeParams) {
		var vm = this;

		vm.colunas = [
			{
				value 	: 'titulo',
				name 	: 'Título'	
			},
			{
				value 	: 'ativo',
				name 	: 'Status'
			}
		];

		active();


		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active() {
			var functions = [getTipoImovel(), getTipoImoveis()];
		}

		function getTipoImovel(){
			if($routeParams.slug !== undefined){
				Request.get("tipoimoveis/" + $routeParams.slug)
					.then(function(res){
						vm.tipoimovel = res[0].objeto;
				});
			}
		}

		function getTipoImoveis(){
			Request.get("tipoimoveis").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";
				});
				vm.tipoimoveis = res[0].objeto;
			});
		}

		vm.busca = function(){
			var data = {
				valor : $("#busca").val(),
				coluna: $("#coluna").val()
			}

			Request.set('busca/tipoimoveis', data).then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					//(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					//(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});
				vm.tipoimoveis = res[0].objeto;
			});

		}

		vm.setTipoImovel = function() {
			var data = {
				titulo:  		$("#tipo-titulo").val(),
				ativo:   		$("#ativo").val()
			};
			
			Request.set('tipoimoveis', data).then(function(res){
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
				titulo:  		$("#tipo-titulo").val(),
				ativo:   		$("#ativo").val()
			};

			Request.put("tipoimoveis/" + $routeParams.slug, data)
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
			Request.destroy('tipoimoveis/' + id)
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