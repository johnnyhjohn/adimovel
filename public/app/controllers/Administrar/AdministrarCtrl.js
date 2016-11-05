(function(){
	'use strict';

	angular.module('adimovelApp').controller('AdministrarCtrl', Administrar);

	Administrar.injector = ["Request", "URL", "$routeParams"];

	function Administrar(Request, URL, $routeParams){

		var vm = this;
		var user = localStorage.getItem('user');
		vm.movimento;
		if(user){
			vm.user = JSON.parse(user);
		}

		vm.colunas = [
			// {
			// 	value 	: 'id_imovel',
			// 	name : 'Imovel'	
			// },
			// {
			// 	value 	: 'id_proprietario',
			// 	name : 'Proprietario'
			// },
			// {
			// 	value 	: 'id_inquilino',
			// 	name : 'Inquilino'
			// },
			{
				value 	: 'nr_contrato',
				name : 'Numero Contrato'
			},
			// {
			// 	value 	: 'finalidade',
			// 	name : 'Finalidade'
			// }
		];


		active();

		setTimeout(function(){
			$("#coluna").find('option:first').remove();
		}, 500);

		function active(){
			var functions = [getMovimentos(), getMovimentacoes(),getMovimento()];
		}

		/*
		//  Cadastro do imóvel em ADMINISTRAR
		*/
		vm.setContrato = function(){
			var data = {
				imovel 	 		: $("#imovel").val(),
				proprietario 	: $("#proprietario").val(),
				inquilino 		: $("#inquilino").val(),
				nr_contrato 	: $("#nr_contrato").val(),
				dt_inicio 		: $("#dt_inicio").val(),
				dt_vencimento 	: $("#dt_vencimento").val(),
				valor 	 		: $("#valor").val(),
				situacao 	 	: $("#situacao").val(),
				finalidade 		: $("#finalidade").val()
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
					(value.finalidade == "VEN") ? value.finalidade = "Venda" : value.finalidade = "Aluguel";
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
				
				vm.movimentos = res[0].objeto;
			});
		}

		function getMovimento(){
		    var meses;

			var nome_meses = ['Janeiro','Fevereiro','Março', 'Abril', 'Maio', 'Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
			if($routeParams.slug !== undefined){
				Request.get("administrar/" + $routeParams.slug)
					.then(function(res){
						var contrato = res[0].objeto;
						var dt_inicio = new Date(contrato.dt_inicio);
						var dt_final  = new Date(contrato.dt_vencimento);
						var mes = (dt_inicio.getMonth() + 1);
						var i = 0;
						var count = 0;
						meses = (dt_final.getFullYear() - dt_inicio.getFullYear()) * 12;
					    meses -= dt_inicio.getMonth() + 1;
					    meses += dt_final.getMonth();
					    meses = meses <= 0 ? 0 : meses;
						(contrato.finalidade == "VEN") ? contrato.finalidade = "Venda" : contrato.finalidade = "Aluguel";
						(contrato.situacao_pagamento == true) ? contrato.situacao_pagamento = "Pago" : contrato.situacao_pagamento = "Pendente";
						vm.movimento = res[0].objeto;
						
						vm.meses = {};
						vm.situacao_aluguel = {};

						console.log(contrato);
					 	
					 	Request.get("administrar/movimento/" + $routeParams.slug)
							.then(function(res){
								
							var movimento = res[0].objeto;
							// (value.situacao_pagamento == true) ? value.situacao_pagamento = "Pago" : value.situacao_pagamento = "Pendente";
							if(movimento){
								vm.movimentacoes = res[0].objeto;	
								vm.movimento.movimentacoes = vm.movimentacoes;
								vm.movimento.movimentacoes = JSON.parse(vm.movimento.movimentacoes).parcelas;
							}
							for (i = 0; i <= meses + 1; i++) {

								count = i;
								if(mes + i > 11 && mes + i < 24){
									// count = 12 - (i);	
									vm.meses[nome_meses[(mes - 12 + i)] +'-'+(dt_inicio.getFullYear() + 1)] = mes + i;
									// vm.meses[nome_meses[(dt_final.getMonth() - 12 + i)]];
								} else if(mes  + i > 23 && mes + i < 36){
									// count = 24 - i;	
									vm.meses[nome_meses[(mes - 24 + i)] +'-'+(dt_inicio.getFullYear() + 2)] = mes + i;
								} else if(dt_final.getMonth()  + i  > 35 && mes + i < 48){
									// count = (mes + i) - 36;	
									vm.meses[nome_meses[(mes - 36 + i)] +'-'+(dt_inicio.getFullYear() + 3)] = mes + i;
								} else if(dt_final.getMonth()  + i  > 48){
									// count = (mes + i) - 48;	
									vm.meses[nome_meses[(mes - 48 + i)] +'-'+(dt_inicio.getFullYear() + 4)] = mes + i;
								}else if( dt_final.getMonth()  + i  > 64 ){
									vm.meses[nome_meses[(mes - 64 + i)] + "-" + dt_inicio.getFullYear()] = mes + i;
								}				
								else{
									vm.meses[nome_meses[(mes + i)] + "-" + dt_inicio.getFullYear()] = mes + i;
								}
								if(vm.movimento.movimentacoes){
									if(vm.movimento.movimentacoes[i]){
										//console.log(count, contrato.movimentacoes);
										// console.log(JSON.parse(vm.movimentacoes));
										vm.situacao_aluguel[(mes + i)] = contrato.movimentacoes[count].situacao;
										if(contrato.movimentacoes[count].situacao == ""){
											vm.situacao_aluguel[mes + i] = "Pendente";		
										}
									};
								} else{
									vm.situacao_aluguel[mes + i] = "Pendente";
								}					
							}
						});
				});
			}
		}

		function getMovimentacoes(){

			// if($routeParams.slug !== undefined){
			// 	 Request.get("administrar/movimento/" + $routeParams.slug)
			// 		.then(function(res){
						
			// 			var value = res[0].objeto;
			// 			// (value.situacao_pagamento == true) ? value.situacao_pagamento = "Pago" : value.situacao_pagamento = "Pendente";
			// 			if(value){
			// 				vm.movimentacoes = res[0].objeto;	
			// 				vm.movimento.movimentacoes = vm.movimentacoes;
			// 				vm.movimento.movimentacoes = JSON.parse(vm.movimento.movimentacoes.movimentacoes).parcelas;
			// 			}
						
			// 	});
			// }		
		}

		/*
		//  Cadastro do movimento de descontos e impostos do imovel
		*/
		vm.setMovimentoVenda = function(){

			var movimentacao = { 
				movimento : 'PAGAMENTO', 
				credito   : true,
				parcelas  : 1,
				entrada   : $("#entrada").val(),
				desconto  : $("#desconto").val(), 
				tipo_pagamento : $("#metodo-pagamento select").val(),				
			};

			if($("#parcela:checked").length > 0) {
				movimentacao.parcelas  		= $("#n_parcela").val();
				movimentacao.valor_parcelas = $("#valor_parcela").val();
				movimentacao.observacao     = $("#descricao").val();
			}

			var data = {
				id_imovel 		: $("#id_imovel").val(),
				id_proprietario : $("#id_proprietario").val(),
				id_inquilino 	: $("#id_inquilino").val(),
				id_usuario 		: vm.user.id,
				id_contrato 	: $("#id_contrato").val(),
				valor 	 		: $("#total").text(),
				data 			: new Date(),
				mes 			: (new Date().getMonth() + 1),
				ano 			: (new Date().getFullYear()),
				movimentacoes	: movimentacao
			}

			
			Request.set("administrar/movimento", data).then(function(res){
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

		vm.alteraAluguel = function() {
			var that = $(event.target);
			if(that.hasClass('ripple-effect')){
				that = that.parents('span');
			}
			if(that.data('situacao') === "pago"){
				that.removeClass('btn-pago').addClass('btn-pendente');
				that.html("Pendente");
				that.data('situacao','pendente');
			} else{
				that.removeClass('btn-pendente').addClass('btn-pago');
				that.html("Pago");
				that.data('situacao','pago');
			}

		}
		
		vm.setMovimentoAluguel = function(){
			
			var movimentacao = {}
			, 	total = $("#total").text();

			if($("#movimento").val() == "Custo"){
				movimentacao = {
					movimento : "ALUGUEL",
					custos 	  : {},
					credito   : true,
					parcelas  : []
				};
				// console.log($("#parcelas").children('li').data('parcela'));
				$("#parcelas").children('li').each(function(key, value)	{
					var data = {
						situacao : $(value).find('span').data('situacao'),
						mes 	 : $(value).data('parcela').split("-")[2],
					}
					movimentacao.parcelas.push(data);
				});
				var custos = [];
				var juros  = 0;
				$(".custo-input").each(function(index, el) {
					var custo = {
						custo : $(el).find(".custo-campo").val(),
						valor : $(el).find(".vlr").val(),
						descricao : $(el).find(".desc").val()
					}
					juros = juros + custo.valor;
					custos.push(custo);
				});

				movimentacao.custos = custos;

				total = total - juros;

				if(total <= 0){
					total = 0;
				}

			} else {
				movimentacao = { 
					movimento : "DESCONTO", 
					valor : $("#desconto").val(), 
					credito : true 
				};
			}
			
			var data = {
				id_imovel 		: $("#id_imovel").val(),
				id_contrato 	: $("#id_contrato").val(),
				id_proprietario : $("#id_proprietario").val(),
				id_inquilino 	: $("#id_inquilino").val(),
				id_usuario 		: vm.user.id,
				data 			: new Date(),
				mes 			: (new Date().getMonth() + 1),
				ano 			: (new Date().getFullYear()),
				valor 	 		: total,
				movimentacoes	: movimentacao
			}

			Request.set("administrar/movimento", data).then(function(res){
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

		vm.desconto = function(){
			var desconto = $("#desconto").val();
			var valor = $("#valor").val();

			var total = valor - desconto;
			$("#total").html(total);
			$("#valor-total").val(total);
		}

		vm.updatePagamento = function(){
			if($(".btn-aluguel").data('situacao') === "pago"){
				$(".btn-aluguel").removeClass('btn-pago').addClass('btn-pendente');
				$(".btn-aluguel").html("Pendente");
				$(".btn-aluguel").data('situacao','pendente');
			} else{
				$(".btn-aluguel").removeClass('btn-pendente').addClass('btn-pago');
				$(".btn-aluguel").html("Pago");
				$(".btn-aluguel").data('situacao','pago');
			}

			var situacao = $(".btn-aluguel").data('situacao');

			var data = {
				situacao : situacao,
			}

			Request.put("administrar/situacao/" + vm.movimento.id, data)
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

		vm.change = function(tipo) {
			Request.get("administrar/"+tipo).then(function(res){
				angular.forEach(res[0].objeto, function(value, key) {
					(value.finalidade == "VEN") ? value.finalidade = "Venda" : value.finalidade = "Aluguel";
					(value.situacao_pagamento == true) ? value.situacao_pagamento = "Pago" : value.situacao_pagamento = "Pendente";
				});
				
				vm.movimentos = res[0].objeto;
			});
		}
	}
	
})();