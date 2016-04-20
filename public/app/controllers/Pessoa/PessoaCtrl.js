(function(){
	'use strict';

	angular.module('adimovelApp').controller('PessoaCtrl', Pessoa);

	Pessoa.injector = ["Request", "URL", "$routeParams"];

	function Pessoa(Request, URL, $routeParams){

		var vm = this;

		active();

		function active(){
			var functions = [getPessoas(), getPessoa()];
		}

		vm.setPessoa = function(){
			var data = {
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

		vm.update = function(){
			var data = {
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

		function getPessoas(){
			Request.get("pessoa").then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.tipo_pessoa == "INQ") ? value.tipo_pessoa = "Inquilino" : value.tipo_pessoa = "Proprietário";

				});
				vm.pessoas = res[0].objeto;
			});
		}

		function getPessoa(){
			if($routeParams.slug !== undefined){
				console.log($routeParams.slug);
				Request.get("pessoa/" + $routeParams.slug)
					.then(function(res){
						vm.pessoa = res[0].objeto;
				});
			}
		}
	}

})();