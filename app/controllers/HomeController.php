<?php

class HomeController extends BaseController {

	protected $page;
	protected $issue;

	function __construct(Page $page, Issue $issue)
	{
		$this->page = $page;
		$this->issue = $issue;
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
		$issue = $this->issue->getCurrent();
		if ( ! $issue) {
			return $this->showPage('index');
		}
		$issue->load('stories.author');
		return View::make('cover')->with('issue', $issue);
	}

}
