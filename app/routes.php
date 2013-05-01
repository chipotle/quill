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
        return Redirect::route('sysop.pages.index');
    });
    Route::resource('pages', 'Admin_PagesController');
    Route::resource('pitches', 'Admin_PitchesController');

    Route::get('/do', function() {
    	for ($i=1; $i < 50; $i++) {
    		$p = new Pitch();
    		$p->name = "Author $i";
    		$p->email = "author$i@gmail.com";
    		$p->blurb = "Lorem ipsum $i et cetera herein forthwith and blah blah blah to the maximum something something furry.";
    		$p->save();
    	}
    	return "Done.";
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
