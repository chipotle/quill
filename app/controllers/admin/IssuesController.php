<?php namespace Admin;

class IssuesController extends \BaseController {

	protected $issue;

	protected $rules = [
		'number' => 'required|numeric|min:1',
		'volume' => 'required|numeric|min:1',
		'pub_date' => 'required|date_format:Y-m-d',
	];

	function __construct(\Issue $issue)
	{
		$this->issue = $issue;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$issues = $this->issue->orderBy('number', 'desc')->paginate(15);
		return \View::make('admin.issues.index')->with('issues', $issues);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$issue = $this->issue->findOrFail($id);
		return \View::make('admin.issues.show')->with('issue', $issue);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$issue = $this->issue;
		$vol = \DB::table('issues')->max('volume');
		if (empty($vol)) $vol = 1;
		$issue->volume = $vol;
		$num = \DB::table('issues')->where('volume', $vol)->max('number');
		$issue->number = $num + 1;
		return \View::make('admin.issues.new')->with('issue', $issue);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = \Input::all();
		$issue = $this->issue;
		$validator = \Validator::make($input, $this->rules);
		if ($validator->fails()) {
			\Session::flashInput($input);
			return \Redirect::route('sysop.issues.create')->with('error', $validator->messages());
		}
		$issue->fill($input);
		$issue->save();
		return \Redirect::route('sysop.issues.index')->with('msg', "Issue {$issue->volume}.{$issue->number} created.");
	}

	/**
	 * Show the form for editing the specified resource.
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = \Input::all();
		$issue = $this->issue->findOrFail($id);
		$validator = \Validator::make($input, $this->rules);
		if ($validator->fails()) {
			\Session::flashInput($input);
			return \Redirect::route('sysop.issues.edit', $issue->id)->with('error', $validator->messages());
		}
		$issue->fill($input);
		if (!\Input::has('is_published')) $issue->is_published = false;
		$msg = "Issue {$issue->volume}.{$issue->number} updated.";
		$issue->save();
		return \Redirect::route('sysop.issues.index')->with('msg', $msg);
	}

	/**
	 * Remove the specified resource from storage.
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
		if ($issue->pub_date == 0) $issue->pub_date = date('Y-m-d');
		$issue->save();
		return \Redirect::route('sysop.issues.index')->with('msg', "Issue {$issue->volume}.{$issue->number} published!");
	}

}