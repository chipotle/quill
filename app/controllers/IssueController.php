<?php

class IssueController extends BaseController {

	protected $issue;
	protected $story;

	function __construct(Issue $issue, Story $story)
	{
		$this->issue = $issue;
		$this->story = $story;
	}

	/**
	 * Get an index of published issues.
	 *
	 * @return View response object
	 */
	public function getIndex()
	{
		$issues = $this->issue->where('is_published', true)->orderBy('number', 'desc')->paginate(15);
		return View::make('issues.index')->with('issues', $issues);
	}

	/**
	 * Get the table of contents for a specific issue.
	 *
	 * @param  integer $id
	 * @return View response object
	 */
	public function showIssue($id)
	{
		$issue = $this->issue->where('is_published', true)->findOrFail($id);
		return View::make('issues.toc')->with('issue', $issue);
	}

	/**
	 * Show a story within an issue.
	 *
	 * @param  integer $id
	 * @param  string $slug
	 * @return View response object
	 */
	public function showStory($id, $slug)
	{
		$story = $this->story->where('issue_id', $id)->where('slug', $slug)->first();
		if ($story && $story->issue->is_published) {
			return View::make('issues.story')->with($story->getContent());
		}
		return Response::view('404', [], 404);
	}

}
