<?php

class IssueController extends BaseController {

	protected $issue;
	protected $story;

	function __construct(Issue $issue, Story $story)
	{
		$this->issue = $issue;
		$this->story = $story;
	}

	public function getIndex()
	{
		// produce paginated index of past issues
	}

	public function showIssue($id)
	{
		// show TOC for a specified issue
	}

	public function showStory($id, $slug)
	{
		$story = $this->story->where('issue_id', $id)->where('slug', $slug)->first();
		if ($story) {
			return View::make('story')->with($story->getContent());
		}
		return Response::make('Page not found', 404);
	}

}
