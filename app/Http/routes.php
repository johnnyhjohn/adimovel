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


Route::any('/admin/login', function(){
    return view("login");
})->where("path", ".+");


Route::any('/admin/{path?}', function(){
    return view("index");
})->where("path", ".+");

// Route::any('{path?}', function(){
//     return view("site");
// })->where("path", ".+");


Route::group(['prefix' => 'data'], function(){
	Route::group(['prefix' => 'pessoa'], function(){
	    Route::post('', 'PessoaController@create');
	    Route::get('{id?}', 'PessoaController@index');
	    Route::put('{id}', 'PessoaController@update');
	    Route::delete('{id}', 'PessoaController@destroy');
	});
	Route::group(['prefix' => 'usuario'], function(){
	    Route::post('', 'UsuarioController@create');
	    Route::get('', 'UsuarioController@show');
	});
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
