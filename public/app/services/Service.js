(function(){
	'use strict';

	angular.module('adimovelApp').factory("Request", Request);


	Request.$injector = ["$http", "URL"];

	function Request($http, URL){

		var vm = this;


		// Cria o objeto do serviço com os métodos contidos
		var service = {
			get : get,
			set : set
		}
		
		// Retorno do serviço é o objeto com os métodos
		return service;
		
		/*
		* 	@description
		* 	Método que faz todos os requests, recebendo o método requestAll()
		* 	Que contem um Array de requisições http, recebendo todos os posts
		*
		* 	@return {Array} posts
		*/
		function get(url){
			return $http(requestGet(url))
	            .then(function(data, status, headers, config) {
	            	console.log(url, data);
	                return data.data;
	            }, function(error){
	                console.log(error);
	                return error;
            })			
		}		
		/*
		* 	@description
		* 	Método que realiza as requisições POST
		*
		* 	@return {Array} posts
		*/
		function set(url, params){
			return $http(requestPost(url, params))
	            .then(function(data, status, headers, config) {
	            	console.log(data);
	                return data.data;
	            }, function(error){
	                console.log(error);
	                return error;
            })			
		}
		function requestPost(url, params){
			return {
				method  : 'POST',
				url 	: URL.data  + url,
				data 	: params
			}
		}
		/*
		* 	@description
		*	Método que monta o objeto de requisição http
		*
		*	@param {String} url
		* 	@return {Object} requestGet
		*/
		function requestGet(url){
			return {
				method  : 'GET',
				url 	: URL.data  + url
			}
		}
	}
})();