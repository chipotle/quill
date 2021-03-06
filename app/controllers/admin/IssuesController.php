<?php namespace Admin;

class IssuesController extends \BaseController {

	protected $issue;
	protected $story;

	function __construct(\Issue $issue, \Story $story)
	{
		$this->issue = $issue;
		$this->story = $story;
	}
	/**
	 * Display a listing of the issues.
	 *
	 * @return Response
	 */
	public function index()
	{
		$issues = $this->issue->orderBy('number', 'desc')->paginate(15);
		return \View::make('admin.issues.index')->with('issues', $issues);
	}

	/**
	 * Display the specified issue.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$issue = $this->issue->with(['stories' => function($q) {
			$q->orderBy('sort');
		}])->findOrFail($id);
		$issue->stories->load('author');
		$unassigned = $this->story->whereNull('issue_id')->with('author')->get();
		return \View::make('admin.issues.show')->with(['issue' => $issue, 'unassigned' => $unassigned]);
	}

	/**
	 * Show the form for creating a new issue.
	 *
	 * @return Response
	 */
	public function create()
	{
		$issue = $this->issue;
		$num = $issue->getCurrentNum();
		$issue->number = $num + 1;
		return \View::make('admin.issues.new')->with('issue', $issue);
	}

	/**
	 * Store a newly created issue in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$issue = $this->issue->fill(\Input::all());
		if ($issue->validate()) {
			$issue->save();
			return \Redirect::route('sysop.issues.index')->with('msg', "Issue {$issue->number} created.");
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.issues.create')->with('error', $issue->errors);
	}

	/**
	 * Show the form for editing the specified issue.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$issue = $this->issue->findOrFail($id);
		return \View::make('admin.issues.edit')->with('issue', $issue);
	}

	/**
	 * Update the specified issue in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$issue = $this->issue->findOrFail($id);
		$issue->fill(\Input::all());
		if (!\Input::has('is_published')) $issue->is_published = false;
		if ($issue->validate()) {
			$issue->save();
			return \Redirect::route('sysop.issues.index')->with('msg', "Issue {$issue->number} updated.");
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.issues.edit', [$issue->id])->with('error', $issue->errors);
	}

	/**
	 * Remove the specified issue from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$issue = $this->issue->find($id);
		$issue->delete();
		\Session::flash('msg', "Issue '{$issue->id}' deleted!");
		$response = ['redirect'=>\URL::route('admin.issues.index')];
		return \Response::json($response);
	}

	/**
	 * Publish an issue.
	 *
	 * @param int $id
	 * @return Response
	 */
	public function publish($id)
	{
		$issue = $this->issue->findOrFail($id);
		$issue->is_published = true;
		if (! $issue->pub_date) $issue->pub_date = date('Y-m-d');
		$issue->save();
		return \Redirect::route('sysop.issues.index')->with('msg', "Issue {$issue->number} published!");
	}

	/**
	 * Commit the contents of an issue.
	 *
	 * @return Response
	 */
	public function commit()
	{
		$contents = \Input::get('contents') ?: array();
		$issue_id = \Input::get('issue');
		$issue = $this->issue->findOrFail($issue_id);
		$current = $this->story->where('issue_id', $issue_id)->lists('id');
		$removed = array_diff($current, $contents);
		$order = 1;
		foreach ($contents as $story_id) {
			$item = $this->story->findOrFail($story_id);
			$item->sort = $order++;
			$item->issue()->associate($issue);
			$item->save();
		}
		foreach ($removed as $story_id) {
			$item = $this->story->findOrFail($story_id);
			$item->sort = null;
			$item->issue_id = null;
			$item->save();
		}
		return \Response::make('OK', 200);
	}

}
