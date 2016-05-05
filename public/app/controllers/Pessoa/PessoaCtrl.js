(function(){
	'use strict';

	angular.module('adimovelApp').controller('PessoaCtrl', Pessoa);

	Pessoa.injector = ["Request", "URL", "$routeParams"];

	function Pessoa(Request, URL, $routeParams){

		var vm = this;
		var user = localStorage.getItem('user');

		if(user){
			vm.user = JSON.parse(user);
		}

		vm.colunas = [
			{
				value 	: 'nm_pessoa',
				name : 'Nome'	
			},
			{
				value 	: 'email',
				name : 'Email'
			},
			{
				value 	: 'nr_telefone',
				name : 'Telefone'
			},
			{
				value 	: 'endereco',
				name : 'Endereço'
			},
			{
				value 	: 'tp_pessoa',
				name : 'Tipo'
			}
		];


		active();

		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active(){
			var functions = [getPessoas(), getPessoa()];
		}

		vm.setPessoa = function(){
			var data = {
				token 	 : vm.user.token.token,
				nome 	 : $("#nome").val(),
				tipo 	 : $("#tipo").val(),
				dta_nasc : $("#dta_nasc").val(),
				email 	 : $("#email").val(),
				telefone : $("#telefone").val(),
				endereco : $("#endereco").val(),
				bairro 	 : $("#bairro").val(),
				cep 	 : $("#cep").val(),
				cpf 	 : $("#cpf").val(),
				rg 		 : $("#rg").val(),
				cidade 	 : $("#cidade").val(),
				lat 	 : $(".lat").val(),
				lng 	 : $(".lng").val()
			}
			Request.set("pessoa", data).then(function(res){
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
				token 	 : vm.user.token.token,
				nome 	 : $("#nome").val(),
				tipo 	 : $("#tipo").val(),
				dta_nasc : $("#dta_nasc").val(),
				email 	 : $("#email").val(),
				telefone : $("#telefone").val(),
				endereco : $("#endereco").val(),
				bairro 	 : $("#bairro").val(),
				cep 	 : $("#cep").val(),
				cpf 	 : $("#cpf").val(),
				rg 		 : $("#rg").val(),
				cidade 	 : $("#cidade").val(),
				lat 	 : $(".lat").val(),
				lng 	 : $(".lng").val()
			};

			Request.put("pessoa/" + $routeParams.slug, data)
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
			Request.destroy('pessoa/' + id)
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

			Request.set('busca/pessoa', data).then(function(res) {
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tp_pessoa == "INQ") ? value.tp_pessoa = "Inquilino" : value.tp_pessoa = "Proprietário";

				});
				vm.pessoas = res[0].objeto;
			});

		}

		function getPessoas(){
			Request.get("pessoa").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tp_pessoa == "INQ") ? value.tp_pessoa = "Inquilino" : value.tp_pessoa = "Proprietário";

				});
				console.log(res);
				vm.pessoas = res[0].objeto;
			});
		}

		function getPessoa(){
			if($routeParams.slug !== undefined){
				Request.get("pessoa/" + $routeParams.slug)
					.then(function(res){
						vm.pessoa = res[0].objeto;
				});
			}
		}
	}

})();