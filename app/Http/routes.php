<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('admin/login', 'Auth\AuthController@getLogin');

Route::group(['prefix' => 'data'], function()
{
	Route::group(['prefix' => 'administrar'], function()
	{
	    Route::post('', 'AdministrarController@create');
	    Route::get('{id?}', 'AdministrarController@index');
	    Route::put('{id}', 'AdministrarController@update');
	    Route::delete('{id}', 'AdministrarController@destroy');
	});

	Route::group(['prefix' => 'imoveis'], function()
	{
	    Route::post('', 'ImovelController@create');
	    Route::get('{id?}', 'ImovelController@index');
	    Route::put('{id}', 'ImovelController@update');
	    Route::delete('{id}', 'ImovelController@destroy');
	});

	Route::group(['prefix' => 'tipoimoveis'], function()
	{
	    Route::post('', 'TipoImovelController@create');
	    Route::get('{id?}', 'TipoImovelController@index');
	    Route::put('{id}', 'TipoImovelController@update');
	    Route::delete('{id}', 'TipoImovelController@destroy');
	});

	Route::group(['prefix' => 'pessoa'], function()
	{
	    Route::post('', 'PessoaController@create');
	    Route::get('{id?}', 'PessoaController@index');
	    Route::put('{id}', 'PessoaController@update');
	    Route::delete('{id}', 'PessoaController@destroy');
	});

	Route::group(['prefix' => 'usuario'], function()
	{
		//Route::get('{id?}', 'UsuarioController@index');
	    Route::post('', 'UsuarioController@create');
	    Route::get('corretor', 'UsuarioController@getCorretores');
	    Route::get('{id?}', 'UsuarioController@index');
	    Route::put('{id}', 'UsuarioController@update');
	    Route::delete('{id}', 'UsuarioController@destroy');
	});

	Route::group(['prefix' => 'busca'], function()
	{
		Route::group(['prefix' => 'pessoa'], function()
		{
		    Route::post('', 'PessoaController@busca');
		});
		
		Route::group(['prefix' => 'usuario'], function()
		{
		    Route::post('', 'UsuarioController@busca');
		});

		Route::group(['prefix' => 'tipoimoveis'], function()
		{
		    Route::post('', 'TipoImovelController@busca');
		});

		Route::group(['prefix' => 'administrar'], function()
		{
		    Route::post('', 'AdministrarController@busca');
		});
	});

	Route::group(['middleware' => ['api','cors'],'prefix' => 'login'], function () {
	    Route::get('', 'AutenticacaoController@login');
	});

    Route::resource('authenticate', 'AutenticacaoController', ['only' => ['index']]);
    Route::post('authenticate', 'AutenticacaoController@authenticate');
    Route::post('authenticate/user', 'AutenticacaoController@getAuthenticatedUser');
});

Route::group(['prefix' => 'admin'], function () 
{
	Route::any('{path?}', function()
	{
	    return view("index");

	})->where("path", ".+");

});

Route::any('{path?}', function()
{
    return view("site");

})->where("path", ".+");
