<?php

// For basic auth, we want to use the username, not the email address
Route::filter('auth.basic', function()
{
    Config::set('auth.model', 'User');
    return Auth::basic('username');
});

// get the "index" page if we hit the main site
Route::get('/', function()
{
    $page = Page::where('slug', 'index')->first();
    return View::make('page')->with($page->getContent());
});

// Admin (back end) routes
Route::group(['prefix' => 'sysop', 'before' => 'auth.basic'], function()
{
	// Index
    Route::get('/', function()
    {
        return Redirect::route('sysop.pitches.index');
    });

    // REST controllers
    Route::resource('pages', 'Admin\PagesController');
    Route::resource('issues', 'Admin\IssuesController');
    Route::get('issues/publish/{id}', ['uses'=>'Admin\IssuesController@publish', 'as'=>'sysop.issues.publish']);

    // Pitches - we can't use REST routes because we need to switch between
    // showing all pitches and only pending pitches on the index page
    Route::get('pitches/{show?}', ['uses'=>'Admin\PitchesController@index', 'as'=>'sysop.pitches.index']);
    Route::get('pitches/show/{id}', ['uses'=>'Admin\PitchesController@show', 'as'=>'sysop.pitches.show']);
    Route::get('pitches/edit/{id}', ['uses'=>'Admin\PitchesController@edit', 'as'=>'sysop.pitches.edit']);
    Route::put('pitches/update/{id}', ['uses'=>'Admin\PitchesController@update', 'as'=>'sysop.pitches.update']);

    // Temporary route used to do arbitrary things
    Route::get('/do', function() {
    	return "Beep!\n";
    });
});

// Static page display
Route::get('/page/{slug}', function($slug)
{
    $page = Page::where('slug', $slug)->first();
    if (empty($page) || !$page->is_visible) {
        return Response::make('Page not found', 404);
    }
    return View::make('page')->with($page->getContent());
});

// "Pitch a story" form
Route::controller('pitch', 'PitchController');

// Queue postback URL (for iron.io)
Route::post('cnq-queue', function()
{
	return Queue::marshal();
});
