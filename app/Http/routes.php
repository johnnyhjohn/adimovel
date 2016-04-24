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
	Route::group(['prefix' => 'pessoa'], function()
	{
	    Route::post('', 'PessoaController@create');
	    Route::get('{id?}', 'PessoaController@index');
	    Route::put('{id}', 'PessoaController@update');
	    Route::delete('{id}', 'PessoaController@destroy');
	});

	Route::group(['prefix' => 'usuario'], function()
	{
	    Route::post('', 'UsuarioController@create');
	    Route::get('', 'UsuarioController@show');
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
