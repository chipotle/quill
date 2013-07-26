<?php

// Admin (back end) routes

Route::group(['prefix' => 'sysop', 'before' => 'auth.basic'], function()
{
	// Index
	Route::get('/', 'Admin\PitchesController@index');

	Route::resource('pages', 'Admin\PagesController');
	Route::resource('authors', 'Admin\AuthorsController');
	Route::resource('stories', 'Admin\StoriesController');
	Route::resource('issues', 'Admin\IssuesController');
	Route::get('issues/publish/{id}', ['uses'=>'Admin\IssuesController@publish', 'as'=>'sysop.issues.publish']);

	// Pitches need to switch between showing all and pending
	Route::get('pitches/{show?}', ['uses'=>'Admin\PitchesController@index', 'as'=>'sysop.pitches.index']);
	Route::get('pitches/show/{id}', ['uses'=>'Admin\PitchesController@show', 'as'=>'sysop.pitches.show']);
	Route::get('pitches/edit/{id}', ['uses'=>'Admin\PitchesController@edit', 'as'=>'sysop.pitches.edit']);
	Route::put('pitches/update/{id}', ['uses'=>'Admin\PitchesController@update', 'as'=>'sysop.pitches.update']);

	// Temporary route used to do arbitrary things
	Route::get('/do', function() {
		return '<pre>Environment: ' . App::environment() . "</pre>\n";
	});
});

// Static page display
Route::get('/page/{slug}', 'StaticController@showPage');
Route::get('/', 'StaticController@index');

// "Pitch a story" form
Route::controller('pitch', 'PitchController');

// Queue postback URL (for iron.io)
Route::post('cnq-queue', function()
{
	return Queue::marshal();
});

// Debugging stuff
if (Request::has('debug') && App::environment() == 'local') {
	Event::listen('illuminate.query', function($sql)
	{
		echo "<pre>$sql</pre>\n";
	});
}
