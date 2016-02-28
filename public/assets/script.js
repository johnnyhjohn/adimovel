'use strict';

$.fn.material_input = function(){
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
	})
})();

+(function menu_open(){
	$(document).on("click", ".menu", function(){
		$("nav").toggleClass("compressed");
		$(".menu").toggleClass("menu-open");
		$("#overlay").toggleClass("overlay-show");
		$("#panel-master").toggleClass('col-md-11 col-md-offset-1').toggleClass('col-md-12');
	});	
})();


$(document).ready(function(){
	

	var CSRF_TOKEN 	= $('meta[name="csrf-token"]').attr('content')
	,	url 		= window.location.href
	,   date 		= new Date()
	,	mes 		= date.getMonth();

	
	$(document).on('focus', '.material-input', function(event) {
		$('input').material_input();
		$('select').material_input();
		$("textarea").material_input();
	});

	
	$(document).on("click", ".avatar-admin", function(){
		$(".user-info").toggleClass('show-info');
	});



})



