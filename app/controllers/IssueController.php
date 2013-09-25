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
		$issues = $this->issue->where('is_published', true)->orderBy('number', 'desc')->paginate(15);
		return View::make('issues.index')->with('issues', $issues);
	}

	public function showIssue($id)
	{
		$issue = $this->issue->where('is_published', true)->findOrFail($id);
		return View::make('issues.toc')->with('issue', $issue);
	}

	public function showStory($id, $slug)
	{
		$story = $this->story->where('issue_id', $id)->where('slug', $slug)->where('is_published', true)->first();
		if ($story) {
			return View::make('issues.story')->with($story->getContent());
		}
		return Response::make('Page not found', 404);
	}

}
