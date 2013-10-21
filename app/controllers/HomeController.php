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
			return Response::view('404', [], 404);
		}
		return View::make('page')->with($page->getContent());
	}

	public function index()
	{
		$issue = $this->issue->getCurrent();
		if (! $issue) {
			return $this->showPage('index');
		}
		return View::make('cover')->with('issue', $issue);
	}

	public function feed()
	{
		$issues = $this->issue->getPublishedIssues();
		if (count($issues) == 0) {
			return Response::make('No articles available', 500);
		}

		$feed = Feed::make();
		$feed->title = 'Claw &amp; Quill';
		$feed->description = 'The Furry/Anthropomorphic Review';
		$feed->icon = 'http://clawandquill.net/cnq-icon-32.png';
		$feed->logo = 'http://clawandquill.net/img/cnq-logo.png';
		$feed->link = URL::action('HomeController@feed');
		$feed->pubdate = $issues[0]->pub_date;
		$feed->lang = 'en';

		foreach ($issues as $issue) {
			foreach ($issue->storiesSorted() as $story) {
				$feed->add(
					$story->title . ' (#' . $issue->number . ')',
					$story->author->getPreferredName(),
					URL::action('IssueController@showStory', [$issue->id, $story->slug]),
					$issue->pub_date,
					$story->getBlurb()
				);
			}
		}

		return $feed->render();
	}

}
