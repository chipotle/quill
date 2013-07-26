<?php namespace Admin;

class StoriesController extends \BaseController {

	protected $story;

	function __construct(\Story $story)
	{
		$this->story = $story;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// $stories = $this->story->with('author', 'issue')->get(); //->paginate(30);
		$stories = \DB::table('stories')->join('authors', 'authors.id', '=', 'stories.author_id')->leftJoin('issues', 'issues.id', '=', 'stories.issue_id')->select('stories.id', 'stories.title', 'issues.number', 'authors.email', 'authors.name')->orderBy('authors.name', 'asc')->paginate(30);
		return \View::make('admin.stories.index')->with('stories', $stories);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$story = $this->story->findOrFail($id);
		return \View::make('admin.stories.show')->with($story->getContent());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$story = $this->story;
		$story->show = \Story::SHOW_NAME;
		$user = \App::make('User');
		$userlist = $user->lists('username', 'id');
		$users = [null => '(None)'] + $userlist;
		return \View::make('admin.stories.new')->with(['story' => $story, 'users' => $users]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$story = $this->story->fill(\Input::all());
		if ($story->validate()) {
			$story->save();
			return \Redirect::route('sysop.stories.index')->with('msg', "Story '{$story->name}' created.");
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.stories.create')->with('error', $story->errors);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$story = $this->story->findOrFail($id);
		return \View::make('admin.stories.edit')->with('story', $story);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$story = $this->story->findOrFail($id);
		$story->fill(\Input::all());
		if ($story->validate()) {
			$story->save();
			return \Redirect::route('sysop.stories.index')->with('msg', "Story '{$story->title}' updated.");
		}
		\Session::flashInput($story->getAttributes());
		return \Redirect::route('sysop.stories.edit', [$id])->with('error', $story->errors);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$story = $this->story->find($id);
		if (count($story->stories) > 0) {
			\Session::flash('error', "{$story->name} has stories in the database and cannot be deleted.");
			$response = ['reload'=>\URL::route('sysop.stories.index')];
		}
		$story->delete();
		\Session::flash('msg', "{$story->name} deleted!");
		$response = ['redirect'=>\URL::route('sysop.stories.index')];
		return \Response::json($response);
	}

}
