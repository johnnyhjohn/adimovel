(function(){
	'use strict';

	angular.module('adimovelApp').controller('ImovelCtrl', Imovel);

	Imovel.injector = ['Request', "URL", "$routeParams", "$interval"];

	function Imovel(Request, URL, $routeParams, $interval) {
		
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
		// setInterval(getCountImoveis, 10000);
		function active() {
			var functions = [getImovel(), getImoveis(), getCountImoveis()];
		}

		/**
		*
		*
		*/
		function getImovel(){
			if($routeParams.slug !== undefined){
				Request.get("imoveis/" + $routeParams.slug)
					.then(function(res){
						
						if(res[0].objeto.hasOwnProperty('foto')){
							vm.imovel = res[0].objeto.imovel;	
							vm.imovel.foto = res[0].objeto.foto;
						} else{
							vm.imovel = res[0].objeto;
						}
				});
			}
		}

		if($routeParams.pin){
			Request.get("pin/" + $routeParams.pin)
				.then(function(res){
					vm.pin = res[0].objeto;
			});
			
		}

		function getCountImoveis(){
			Request.get("imoveis").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.reservado == true) ? value.reservado = "Reservado" : value.reservado = "Disponível";
					//(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					//(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});
				vm.imoveis_cadastrados = res[0].objeto.length;
			});
			Request.get("imoveis/count-vendas").then(function(res){
				vm.vendas = res[0].objeto.length;
				console.log(vm.vendas)
			});
		}

		function getImoveis(){
			Request.get("imoveis").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					//(value.reservado == true) ? value.reservado = "Reservado" : value.reservado = "Disponível";
					//(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					//(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
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
					(value.reservado == true) ? value.reservado = "Reservado" : value.reservado = "Disponivel";
					//(value.tp_funcionario == "COR") ? value.tp_funcionario = "Corretor" : value.tp_funcionario = "Administrador";
					//(value.ativo == true) ? value.ativo = "Ativo" : value.ativo = "Inativo";		
				});
				vm.imoveis = res[0].objeto;
			});

		}

		vm.imageUpload = function() {
			console.log('tste');
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
			data['imagem_thumb'] = $("#img_prev").attr('src');

			// console.log(data);
			Request.set('imoveis', data).then(function(res){
				var alerta = new alert();
				if (res[0].codigo == "SUCCESS") {
					alerta.success(res[0].mensagem);
					$("#cadastro-imovel").find('input, textarea').each(function(key, value){
						$(value).val('');
					});
					$("#img_prev").attr('src', 'image/no-image-box.png');
				} else if (res[0].codigo == "DANGER") {
					alerta = new alert();
					alerta.danger(res[0].mensagem);
				}
				return res;
			});	
		}

		vm.update = function(){
			var data = {}
			,	date = new Date();

			$("#editar-imovel").find('input, textarea, select').each(function(key, value){
				if($(value).attr('id')){
					data[$(value).attr('id')] = $(value).val();
				}
				data['token'] = vm.user.token.token;
				data['dt_cadastrado'] = (date.getFullYear() +"/"+ (date.getMonth() + 1) + "/"+ date.getDate());
			});
			data['imagem_thumb'] = $("#img_prev").attr('src');

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

		vm.setReserva = function(id){
			
			var data = {
				idimovel : id,
			}

			Request.put("imoveis/reservado/" + id, data)
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
			getImoveis();

		}

		vm.setDisponivel = function(id){
			
			var data = {
				idimovel : id,
			}

			Request.put("imoveis/disponivel/" + id, data)
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
			getImoveis();
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