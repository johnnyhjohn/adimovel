(function(){
	'use strict';

	angular.module('adimovelApp', ['ngRoute']);

	var constantes = {
		data 	: window.location.origin + '/data/',
		partials: window.location.origin + '/partials/'
	}

	angular.module('adimovelApp').constant('URL', constantes);

})();