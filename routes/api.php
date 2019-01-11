<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::post('register', 'Auth\RegisterController@create');

Route::group(['middleware' => 'jwt.auth'], function ($router) {
    Route::delete('teams/{teamId}/players/{playerId}', 'TeamsPlayersController@destroy');

    Route::get('teams/{team}/players', 'TeamsController@players');
    Route::get('teams', 'TeamsController@index');
    Route::post('teams/{team}', 'TeamsController@update');
    Route::post('teams', 'TeamsController@store');
    Route::get('teams/{id}', 'TeamsController@show');
    Route::delete('teams/{id}', 'TeamsController@destroy');

    Route::get('players/{player}/teams', 'PlayersController@teams');
    Route::get('players', 'PlayersController@index');
    Route::post('players/{player}', 'PlayersController@update');
    Route::post('players', 'PlayersController@store');
    Route::get('players/{id}', 'PlayersController@show');
    Route::delete('players/{id}', 'PlayersController@destroy');
});