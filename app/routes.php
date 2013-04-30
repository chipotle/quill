<?php
use Michelf\Markdown;

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
        return View::make('admin.index');
    });
    Route::resource('pages', 'Admin_PagesController');
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