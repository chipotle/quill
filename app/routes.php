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

/**
 * Admin routes - handled by resource controllers in admin/
 */
Route::group(['prefix' => 'sysop', 'before' => 'auth.basic'], function()
{
    Route::get('/', function()
    {
        return Redirect::route('sysop.pitches.index');
    });
    Route::resource('pages', 'Admin\PagesController');

    Route::get('pitches/{show?}', ['uses'=>'Admin\PitchesController@index', 'as'=>'sysop.pitches.index']);
    Route::get('pitches/show/{id}', ['uses'=>'Admin\PitchesController@show', 'as'=>'sysop.pitches.show']);
    Route::get('pitches/edit/{id}', ['uses'=>'Admin\PitchesController@edit', 'as'=>'sysop.pitches.edit']);
    Route::put('pitches/update/{id}', ['uses'=>'Admin\PitchesController@update', 'as'=>'sysop.pitches.update']);

    Route::get('/do', function() {
    	$name = Config::get('quill.pitch.name');
    	$email = Config::get('quill.pitch.email');
    	return "Send email to $name ($email).";
    });
});

/**
 * Static page controller
 */
Route::get('/page/{slug}', function($slug)
{
    $page = Page::where('slug', $slug)->first();
    if (empty($page) || !$page->is_visible) {
        return Response::make('Page not found', 404);
    }
    return View::make('page')->with($page->getContent());
});

/**
 * Pitch form
 */
Route::controller('pitch', 'PitchController');

/**
 * Queue controller
 */
Route::post('cnq-queue', function()
{
	return Queue::marshal();
});
