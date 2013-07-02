<?php namespace Admin;

class IssueController extends \BaseController {

	protected $issue;

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
		$issue = $this->issue->find($id);
		$issue->fill($input);
		$msg = "Issue #{$issue->id} updated.";
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
		$response = ['redirect'=>\URL::route('sysop.issues.index')];
		return \Response::json($response);
	}

}
