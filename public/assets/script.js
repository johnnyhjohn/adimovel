'use strict';

$.fn.material_input = function(){

	$("input, select, textarea").each(function(value, key){
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
	

	$(document).on('mousedown', '.btn', mouseDownRipple);
	$(document).on('mouseup', '.btn', mouseUpRipple);	

	/*
	*	CLICK EVENTS
	*/
	$(document).on("click", ".avatar-admin", toggleAdminAvatar);	
	$(document).on("click", ".menu-ul li", activeLi);
	$(document).on('click', '.ripple', rippleEffect);
	$(document).on('focus', '.date', textToDate);
	$(document).on('blur', '.date', dateToText);
	$(document).on('click', 'a', scrollToTop);
	$(document).on('click', '.btn-custos', toggleCustos);
	$(document).on('click', '.deleta-imovel', function(event) {
		event.preventDefault();
	});
	$(document).on('click', '#myTabs a', function (e) {
	  e.preventDefault()
	  $(this).tab('show')
	})

	addMaterialInput();
})

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
	if($(this).hasClass('btn-pago')){
		$(this).removeClass('btn-pago').addClass('btn-atrasado');
		$(this).html("Atrasado");
		$(this).data('situacao','atrasado');
	}else if($(this).hasClass('btn-atrasado')){
		$(this).removeClass('btn-atrasado').addClass('btn-pendente');
		$(this).html("Pendente");
		$(this).data('situacao','pendente');
	}else if($(this).hasClass('btn-pendente')){
		$(this).removeClass('btn-pendente').addClass('btn-pago');
		$(this).html("Pago");
		$(this).data('situacao','pago');
	}  
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



