(function(){
	'use strict';

	angular.module('adimovelApp').controller('PinCtrl', Pin);

	Pin.injector = ["Request", "URL", "$routeParams"];

	function Pin(Request, URL, $routeParams) {
		var vm = this;

		vm.colunas = [
			{
				value 	: 'titulo',
				name 	: 'Título'	
			}
		];

		active();


		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active() {
			var functions = [getPin(), getPins()];
		}

		function getPin(){
			if($routeParams.slug !== undefined){
				Request.get("pin/" + $routeParams.slug)
					.then(function(res){
						vm.pin = res[0].objeto;
				});
			}
		}

		function getPins(){
			Request.get("pin").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";
				});
				vm.pins = res[0].objeto;
			});
		}

		vm.busca = function(){
			var data = {
				valor : $("#busca").val(),
				coluna: $("#coluna").val()
			}
			
			Request.set('busca/pin', data).then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					//(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					//(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});
				vm.tipoimoveis = res[0].objeto;
			});

		}

		vm.setPin = function() {
			var data = {
				titulo 		:  	$("#titulopin").val(),
				endereco 	:  	$("#endereco").val(),
				nr_endereco :  	$("#nr_endereco").val(),
				bairro		:  	$("#bairro").val(),
				cep 		:  	$("#cep").val(),
				cidade 		:  	$("#cidade").val(),
				observacao 	:   $("#observacao").val(),
				latitude 	:  	$("#latitude").val(),
				longitude 	:   $("#longitude").val()
			};

			Request.set('pin', data).then(function(res){
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
				titulo 		:  	$("#titulopin").val(),
				endereco 	:  	$("#endereco").val(),
				nr_endereco :  	$("#nr_endereco").val(),
				bairro		:  	$("#bairro").val(),
				cep 		:  	$("#cep").val(),
				cidade 		:  	$("#cidade").val(),
				observacao 	:   $("#observacao").val(),
				latitude 	:  	$("#latitude").val(),
				longitude 	:   $("#longitude").val()
			};

			Request.put("pin/" + $routeParams.slug, data)
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
			
			Request.destroy('pin/' + id)
				.then(function(res){
					var alerta = new alert();
					if(res[0].codigo == "SUCCESS"){
						alerta.successDeleta(tr, res[0].mensagem);
					}else if(res[0].codigo == "DANGER"){
						alerta = new alert();
						alerta.danger(res[0].mensagem);
					}					
					return res;
			});
		}

	}

})();