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

		if(scroll >= 50){
			$("nav").addClass('nav-fixed');
			$(".nav-fixed").removeClass('no-transition');
			setTimeout(function(){
				$(".nav-fixed").addClass('transition');
			}, 800);
		}else{
			$(".nav-fixed").removeClass('transition');
			$(".nav-fixed").addClass('no-transition');
			$("nav").removeClass('nav-fixed');
			setTimeout(function(){
				$("nav").removeClass('no-transition');
			}, 400);
		}
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
	$(document).on('mousedown', '.ripple', function (e) {	
		e.preventDefault();
		$(this).css("box-shadow","0 2px 4px rgba(0, 0, 0, 0)");
	});
	$(document).on('mouseup', '.ripple', function (e) {
		e.preventDefault();
		$(this).css("box-shadow","0 2px 4px rgba(0, 0, 0, 0.2)");
	});	
	$(document).on('click', '.ripple', function (event) {
      event.preventDefault();
      
      var $div = $('<div/>'),
          btnOffset = $(this).offset(),
      		xPos = event.pageX - btnOffset.left,
      		yPos = event.pageY - btnOffset.top;
      
      $div.addClass('ripple-effect');
      var $ripple = $(".ripple-effect");
      
      $ripple.css("height", $(this).height());
      $ripple.css("width", $(this).height());
      $div
        .css({
          top: yPos,
          left: xPos - ($ripple.width()/2),
          background: $(this).data("ripple-color")
        }) 
        .appendTo($(this));

      window.setTimeout(function(){
        $div.remove();
      }, 2000);
    });


})



