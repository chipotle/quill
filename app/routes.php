<?php

// Admin (back end) routes

Route::group(['prefix' => 'sysop', 'before' => 'auth.basic'], function()
{
	// Index
	Route::get('/', 'Admin\PitchesController@index');

	Route::get('authors/search', 'Admin\AuthorsController@search');
	Route::get('issues/publish/{id}', ['uses'=>'Admin\IssuesController@publish', 'as'=>'sysop.issues.publish']);
	Route::post('issues/commit', ['uses'=>'Admin\IssuesController@commit', 'as'=>'sysop.issues.commit']);
	Route::get('stories/createby/{author_id}', ['uses'=>'Admin\StoriesController@createWithAuthor', 'as'=>'sysop.stories.createwith']);

	Route::resource('pages', 'Admin\PagesController');
	Route::resource('authors', 'Admin\AuthorsController');
	Route::resource('stories', 'Admin\StoriesController');
	Route::resource('issues', 'Admin\IssuesController');

	// Pitches need to switch between showing all and pending
	Route::get('pitches/{show?}', ['uses'=>'Admin\PitchesController@index', 'as'=>'sysop.pitches.index']);
	Route::get('pitches/show/{id}', ['uses'=>'Admin\PitchesController@show', 'as'=>'sysop.pitches.show']);
	Route::get('pitches/edit/{id}', ['uses'=>'Admin\PitchesController@edit', 'as'=>'sysop.pitches.edit']);
	Route::put('pitches/update/{id}', ['uses'=>'Admin\PitchesController@update', 'as'=>'sysop.pitches.update']);

	// Temporary route used to do arbitrary things
	Route::get('/do', function() {
		$a = \DB::table('stories')->join('authors', 'authors.id', '=', 'stories.author_id')->leftJoin('issues', 'issues.id', '=', 'stories.issue_id')->select('stories.id', 'stories.title', 'issues.volume', 'issues.number', 'authors.email', 'authors.name', 'author_id', 'issue_id')->orderBy('authors.name', 'asc')->get();
		echo "<pre>"; print_r($a); echo "</pre>";
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
