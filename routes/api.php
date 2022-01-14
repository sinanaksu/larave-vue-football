<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('teams', 'App\Http\Controllers\TeamController@index');
Route::get('teams/generate', 'App\Http\Controllers\TeamController@generateTournament');

Route::get('matches', 'App\Http\Controllers\MatchController@index');
Route::get('matches/generate', 'App\Http\Controllers\MatchController@generateMatches');
Route::get('matches/nextweek', 'App\Http\Controllers\MatchController@playNextWeek');
