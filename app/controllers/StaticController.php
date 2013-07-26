<?php

class StaticController extends BaseController {

	protected $page;

	function __construct(Page $page)
	{
		$this->page = $page;
	}

	public function showPage($slug)
	{
		$page = $this->page->where('slug', $slug)->first();
		if (empty($page) || ! $page->is_visible) {
			return Response::make('Page not found', 404);
		}
		return View::make('page')->with($page->getContent());
	}

	public function index()
	{
		return $this->showPage('index');
	}

}
