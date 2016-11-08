'use strict';


var alert = function(){

	var alert = alert || {};
	var vm = this;

	this.success = function(msg){
		$(document).scrollTop(0);
		$(".alert").remove();
		$("header").after("<div class='alert success'><p>"+ msg +"</p></div>");
		vm.deleta();
	}
	this.danger = function(msg){
		$(document).scrollTop(0);
		$(".alert").remove();
		$("header").after("<div class='alert error'><p>"+ msg +"<a class='btn btn-detalhes-error' data-toggle='modal' data-target='#modalRetorno'>Detalhes..</a></p></div>");
		vm.deleta();
	}
	this.deleta = function(){
		setTimeout(function(){
			$(".alert").remove();
		}, 5000);
	}
	this.successDeleta = function(element, msg){
		
		element.append('<p class="p-td">' + msg + '</p>');
		$('.modal').modal('hide');
		setTimeout(function(){
			element.remove();
		}, 5000);
	}
}

/**
*	@author Johnny
*	
*	@description
*	Função que adiciona uma classe para mostrar os campos com erro.
*
*	@param {Object} obj - Objeto de array com os erros
*
*/
var validacao = function( obj ) {

	var validacao = validacao || {};
	var vm = this;

	// Retira de todos o required para adicionar dos novos
	$('.material-input').removeClass('required');

	var i = 0
	,	obj_length = obj.length;

	for(i; i < obj_length; i++){

		if(obj[i].indexOf('O campo') !== -1){
			var campo = obj[i].slice(8).replace(' é obrigatório.', '').replace(' ', '_');
			$("#"+campo).parent('.material-input').addClass('required');
		} else if(obj[i].indexOf('já está em uso') !== -1){
			var campo = obj[i].replace(' já está em uso.', '').replace(' ', '_').toLowerCase();
			$("#"+campo).parent('.material-input').addClass('required');
			console.log(campo);
		}

	}
}

$.fn.material_input = function(){

	$("input[type=text], select, textarea").each(function(value, key){
		if($(this).val() != ""){
			var div 	= $(this).parent('div')
			,	label	= div.find('label')
			,	input 	= div.find('input')
			,	span 	= div.find('span')
			,	textarea= div.find('textarea')
			,	icon	= div.find('i');

			label.addClass('label-active');
			span.addClass('input-focus');
			icon.css('color', '#09f');			
		}
	})

	return $(".material-input").find($(this)).focus(function(){
		var div 	= $(this).parent('div')
		,	label	= div.find('label')
		,	input 	= div.find('input')
		,	span 	= div.find('span')
		,	textarea= div.find('textarea')
		,	icon	= div.find('i');

		label.addClass('label-active');
		span.addClass('input-focus');
		icon.css('color', '#09f');

		$(this).blur(function(){
			var div 	= $(this).parent('div')
			,	label	= div.find('label')
			,	input 	= div.find('input')
			,	span 	= div.find('span');

			if (input.val() == "" || textarea.val() == "") {
				label.removeClass('label-active');
				span.removeClass('input-focus');
				icon.css('color', '#ddd');
			};
		});
	});
};

+(function menu_scroll(){
	$(document).scroll(function(){
		var scroll = $(document).scrollTop();

		scroll >= 50 ? $(".menu").css("top", "80%") : $(".menu").css("top", "140px");

		if(scroll >= 50){
			$("nav").addClass('nav-fixed');
			
			setTimeout(function(){
				$(".nav-fixed").addClass('transition');
			}, 800);
		}else{
			$(".nav-fixed").removeClass('transition');
			$("nav").removeClass('nav-fixed');
		}
	})
})();

+(function menu_open(){
	$(document).on("click", ".menu", function(){
		$("nav").toggleClass("compressed");
		$(".menu").toggleClass("menu-open");
		$("#overlay").toggleClass("overlay-show");
		$("#titulo").toggleClass("compressed");
		$("#panel-master").toggleClass('col-md-11 col-md-offset-1').toggleClass('col-md-12 col-md-offset-0');
	});	
})();


$(document).ready(function(){
	

	var CSRF_TOKEN 	= $('meta[name="csrf-token"]').attr('content')
	,	url 		= window.location.href
	,   date 		= new Date()
	,	mes 		= date.getMonth();

	$(document).on('focus', '.material-input',addMaterialFocus);

	/*
	*	CLICK EVENTS
	*/
	$(document).on("click", ".avatar-admin", toggleAdminAvatar);	
	$(document).on("click", ".menu-ul li", activeLi);
	$(document).on('click', '.ripple', rippleEffect);
	$(document).on('focus', '.date', textToDate);
	$(document).on('blur', 	'.date', dateToText);
	$(document).on('click', 'a', scrollToTop);
	$(document).on('click', '.btn-custos', toggleCustos);
	$(document).on('click', '.deleta-imovel', function(event) {
		event.preventDefault();
	});
	$(document).on('click', '.btn-administra', toggleActiveAlugelCompra);
	$(document).on('click', '.btn-desconto', function(){
		$(".desconto").toggleClass('active');
		$("#desconto").focus();
	});
    $(document).on('click', '.close', function(){
        $("#myModal").modal("hide");
        $("#deleteModal").modal("hide");
    })

    $(document).on('hide.bs.modal',function(){
        $(".modal-body input").css("border","2px inset");
        $(".mensagem-erro").remove();
    })

    $(document).on('click', '.btn-close', function(){
        closeModal();
    });

    $(document).on('click', '.btn-deleta', function(){
        var id = $(this).data('id');

        $(".btn-confirm-delete").data("id",id);

        $("#deleteModal .modal-title").html("Deseja deletar?");
    });

	$(document).on('click', '#btn-add-custo', function(event) {
		var custo = $(this).parents('.col-md-12').find('select').val();

		$("#custo-form").append("\
			<div class='custo-input'>\
				<div class='col-md-4'>\
					<div class='material-input'>\
						<label class='float-label label-active'>Custo</label>\
						<input type='text' class='form-control custo-campo' name='"+ custo +"' value='"+ custo +"'>\
						<span class='input-focus'></span>\
					</div>\
				</div>\
				<div class='col-md-4'>\
					<div class='material-input'>\
						<label class='float-label'>Descrição</label>\
						<input type='text' class='form-control desc' name=''>\
						<span></span>\
					</div>\
				</div>\
				<div class='col-md-3'>\
					<div class='material-input'>\
						<label class='float-label'>Valor</label>\
						<input type='number' class='form-control vlr' name=''>\
						<span></span>\
					</div>\
				</div>\
				<div class='col-md-1'>\
					 <button id='btn-remove-custo' class='btn ripple btn-danger'><i class='fa fa-trash'></i></button>\
				</div>\
			</div>\
		");
	});

	$(document).on('click', '#btn-remove-custo', function(event) {
		$(this).closest('.custo-input').remove();
	});

	addMaterialInput();
})

function toggleActiveAlugelCompra(){
	switch ($(this).hasClass('btn-compra')) {
		case true:
			$('.btn-aluguel').removeClass('active');
			$(this).addClass('active');
		break;
		default:
			$('.btn-compra').removeClass('active')
			$(this).addClass('active');
		break;
	}
}

function montaListaVenda(){
	$(".table").remove();
	$(".busca").after('\
		<table class="table">\
			<tbody><tr id="table-head">\
				<th id="nome" class="filtro">Codigo</th>\
				<th id="celular" class="filtro">Corretor</th>\
				<th id="projeto" class="filtro">Inquilino</th>\
				<th id="telefone" class="filtro">Nome do Imovel</th>\
				<th id="projeto" class="filtro">Pagamento</th>\
				<th>Opções</th>\
			</tr>\
			<tr>\
				<td>01</td>\
				<td>Martonha</td>\
				<td>Juca Bala 2</td>\
				<td>Imóvel 10</td>\
				<td class="pendente">Pendente</td>\
				<td>\
					<a href="admin/administrar/imoveis/compra/1"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>\
					<button class="btn btn-danger btn-deleta" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash-o"></i></button>\
				</td>\
			</tr>\
			<tr>\
				<td>02</td>\
				<td>Juarez Martonha</td>\
				<td>Joao Feijão</td>\
				<td>Imóvel 2</td>\
				<td class="pago">Pago</td>\
				<td>\
					<a href="admin/administrar/imoveis/compra/1"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>\
					<button class="btn btn-danger btn-deleta" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash-o"></i></button>\
				</td>\
			</tr>\
		</tbody></table>')	
}
function montaListaLocacao(){
	$(".table").remove();
	$(".busca").after('\
		<table class="table">\
			<tbody><tr id="table-head">\
				<th id="nome" class="filtro">Codigo</th>\
				<th id="celular" class="filtro">Corretor</th>\
				<th id="projeto" class="filtro">Inquilino</th>\
				<th id="projeto" class="filtro">Proprietário</th>\
				<th id="telefone" class="filtro">Nome do Imovel</th>\
				<th id="projeto" class="filtro">Pagamento</th>\
				<th>Opções</th>\
			</tr>\
			<tr>\
				<td>01</td>\
				<td>Juarez</td>\
				<td>Juca Bala</td>\
				<td>Juca Bala 3</td>\
				<td>Imóvel 1</td>\
				<td class="pendente">Pendente</td>\
				<td>\
					<a href="admin/administrar/imoveis/aluguel/1"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>\
					<button class="btn btn-danger btn-deleta" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash-o"></i></button>\
				</td>\
			</tr>\
			<tr>\
				<td>02</td>\
				<td>Juarez Martonha</td>\
				<td>Joao Feijão</td>\
				<td>Juca Bala 2</td>\
				<td>Imóvel 2</td>\
				<td class="pago">Pago</td>\
				<td>\
					<a href="admin/administrar/imoveis/aluguel/1"><button class="btn btn-primary"><i class="fa fa-pencil"></i></button></a>\
					<button class="btn btn-danger btn-deleta" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash-o"></i></button>\
				</td>\
			</tr>\
		</tbody></table>')	
}

function closeModal(){

    $("#myModal").modal("hide");
    $("#deleteModal").modal("hide");
    $("input").val("");

}


function toggleCustos(){
	$(".custos").toggleClass('active');
}

function textToDate(){
	$(this).attr("type","date");
}
function dateToText(){
	$(this).attr("type","text");
}

function addMaterialFocus(){
	$('input').material_input();
	$('select').material_input();
	$("textarea").material_input();	
}

function scrollToTop(){
	addMaterialInput();
	$(document).scrollTop(0);	
}

function activeLi(){
	$(".menu-ul li").removeClass('active');
	$(this).addClass('active');
}

function mouseDownRipple(e){
	e.preventDefault();
	$(this).css("box-shadow","0 2px 4px rgba(0, 0, 0, 0)");
}

function mouseUpRipple(e){
	e.preventDefault();
	$(this).css("box-shadow","0 2px 4px rgba(0, 0, 0, 0.2)");
}

function toggleAdminAvatar(){
	$(".user-info").toggleClass('show-info');
}

function addMaterialInput(){
	var inputs = setInterval(function(){
		if($(document).find("input")){
			$('input').material_input();
			$('select').material_input();
			$("textarea").material_input();
			clearInterval(inputs);
		}
	}, 200);	
};


function rippleEffect () {
  	event.preventDefault(); 
  	var $div = $('<div/>'),
      	btnOffset = $(this).offset(),
  		xPos = event.pageX - btnOffset.left,
  		yPos = event.pageY - btnOffset.top;
  
  	$div.addClass('ripple-effect');
  	var $ripple = $(".ripple-effect");
  
  	$ripple.css("height", $(this).height());
  	$ripple.css("width", $(this).height());
  	$div.css({
      	top: yPos,
      	left: xPos - ($ripple.width()/2),
      	background: $(this).data("ripple-color")
    }) 
    .appendTo($(this));

  	window.setTimeout(function(){
    	$div.remove();
  	}, 2000);
}



