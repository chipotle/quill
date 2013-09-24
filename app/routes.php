<?php

// Admin (back end) routes
Route::group(['prefix' => 'sysop', 'before' => 'auth.basic'], function()
{
	Route::get('/', 'Admin\PitchesController@index');

	Route::resource('pages', 'Admin\PagesController');
	Route::resource('authors', 'Admin\AuthorsController');
	Route::resource('stories', 'Admin\StoriesController');
	Route::resource('issues', 'Admin\IssuesController');
	Route::resource('images', 'Admin\ImagesController');

	// Pitches need to switch between showing all and pending
	Route::get('pitches/{show?}', ['uses'=>'Admin\PitchesController@index', 'as'=>'sysop.pitches.index']);
	Route::get('pitches/show/{id}', ['uses'=>'Admin\PitchesController@show', 'as'=>'sysop.pitches.show']);
	Route::get('pitches/edit/{id}', ['uses'=>'Admin\PitchesController@edit', 'as'=>'sysop.pitches.edit']);
	Route::put('pitches/update/{id}', ['uses'=>'Admin\PitchesController@update', 'as'=>'sysop.pitches.update']);

	// special callbacks
	Route::get('authors/search', 'Admin\AuthorsController@search');
	Route::get('issues/publish/{id}', ['uses'=>'Admin\IssuesController@publish', 'as'=>'sysop.issues.publish']);
	Route::post('issues/commit', ['uses'=>'Admin\IssuesController@commit', 'as'=>'sysop.issues.commit']);
	Route::get('stories/createby/{author_id}', ['uses'=>'Admin\StoriesController@createWithAuthor', 'as'=>'sysop.stories.createwith']);
});

// Home page display
Route::get('/', 'HomeController@index');

// Other static pages
Route::get('/page/{slug}', ['uses' => 'HomeController@showPage', 'as' => 'page']);

// Issue contents
Route::get('/issue/{id}/{slug}', 'IssueController@showStory');
Route::get('/issue/{id}', 'IssueController@showIssue');
Route::get('/issue', 'IssueController@getIndex');

// Author pages
Route::get('/author/{id}', 'AuthorController@showBio');
Route::get('/author', 'AuthorController@getIndex');

// "Pitch a story" form
Route::controller('pitch', 'PitchController');

// Queue postback URL (for iron.io)
Route::post('cnq-queue', function()
{
	return Queue::marshal();
});

// Allow SQL debugging
if (Request::has('debug') && App::environment() == 'local') {
	Event::listen('illuminate.query', function($sql)
	{
		echo "<pre>$sql</pre>\n";
	});
}
