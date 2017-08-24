<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Landing Route
Route::get('/', function () {
    return view('welcome');
});

// Login Routes
Route::get('auth/facebook', 'Auth\AuthController@redirectToProvider');
Route::get('auth/facebook/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('/logout', 'Auth\AuthController@getSignOut');


// Tournament Routes
Route::get('tournament', 'TournamentController@getActiveTour');
Route::post('create_tournament',['as' => 'create_tournament', 'uses' => 'TournamentController@createTour']);
Route::post('create_team',['as' => 'create_team', 'uses' => 'TournamentController@createTeam']);
Route::post('join_team',['as' => 'join_team', 'uses' => 'TournamentController@joinTeam']);
Route::get('/notifications', 'TournamentController@notifications');


// Course Routes
Route::get('/course', 'CourseController@getHoles');
Route::post('/insertScore', 'CourseController@insertScore');
Route::get('/getScore', 'CourseController@getScore');
Route::post('/insertNote', 'CourseController@insertNotification');

// Standings Routes
Route::get('/standings', 'StandingsController@getStandings');
Route::get('/getScoreCard', 'StandingsController@getScoreCard');
Route::get('/leaderboard', 'PublicController@getPublicBoard');
Route::get('/getScoreCardPublic', 'PublicController@getScoreCard');
Route::get('/lastyear', 'StandingsController@getStandings');

// Map Routes
Route::get('map',['as' => 'map', 'uses' => 'MapController@getMapView']);

// Analytics Routes
Route::get('/analytics', 'AnalyticsController@show');


// Admin Routes
Route::get('admin',['as' => 'admin', 'uses' => 'AdminController@getAdminView']);
Route::post('activate_tour',['as' => 'activate_tour', 'uses' => 'AdminController@activateTour']);
Route::post('create_matchup',['as' => 'create_matchup', 'uses' => 'AdminController@createMatchup']);
Route::post('delete_matchup',['as' => 'delete_matchup', 'uses' => 'AdminController@deleteMatchup']);
Route::post('eject_mate',['as' => 'eject_mate', 'uses' => 'AdminController@ejectMate']);
Route::post('delete_team',['as' => 'delete_team', 'uses' => 'AdminController@deleteTeam']);
Route::post('update_score',['as' => 'update_score', 'uses' => 'AdminController@updateScore']);
Route::post('clear_score',['as' => 'clear_score', 'uses' => 'AdminController@clearScore']);

// Error Route
Route::get('error', array('as' => 'error', 'uses' => function(){
  return view('error');
}));


