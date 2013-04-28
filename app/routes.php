<?php
use Michelf\Markdown;

// basic auth
Route::filter('auth.basic', function()
{
    Config::set('auth.model', 'User');
    return Auth::basic('username');
});

Route::get('/', function()
{
    $page = Page::where('slug', 'index')->first();
    return View::make('page')->with($page->getContent());
});

// Administration functions
Route::group(['prefix' => 'sysop', 'before' => 'auth.basic'], function()
{
    Route::get('/', function()
    {
        return View::make('admin.index');
    });
    Route::resource('pages', 'Admin_PagesController');
});

Route::get('/page/{slug}', function($slug)
{
    $page = Page::where('slug', $slug)->first();
    if (empty($page)) {
        return Response::make('Not Found', 404);
    }
    return View::make('page')->with($page->getContent());
});