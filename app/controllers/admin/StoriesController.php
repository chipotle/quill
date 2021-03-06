<?php namespace Admin;

class StoriesController extends \BaseController {

	protected $story;

	function __construct(\Story $story)
	{
		$this->story = $story;
	}
	/**
	 * Display a listing of the story.
	 *
	 * @return Response
	 */
	public function index()
	{
		$stories = \DB::table('stories')->join('authors', 'authors.id', '=', 'stories.author_id')->leftJoin('issues', 'issues.id', '=', 'stories.issue_id')->select('stories.id', 'stories.title', 'issues.number', 'authors.email', 'authors.name', 'author_id', 'issue_id')->orderBy('authors.name', 'asc')->paginate(30);
		return \View::make('admin.stories.index')->with('stories', $stories);
	}

	/**
	 * Display the specified story.
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
	 * Show the form for creating a new story.
	 *
	 * @return Response
	 */
	public function create()
	{
		$story = $this->story;
		return \View::make('admin.stories.new')->with(['story' => $story, 'author_name' => null]);
	}

	/**
	 * Show the form for creating a new story.
	 *
	 * @return Response
	 */
	public function createWithAuthor($author_id)
	{
		$story = $this->story;
		$story->author_id = $author_id;
		$author_name = \App::make('author')->find($author_id)->getFormName();
		return \View::make('admin.stories.new')->with(['story' => $story, 'author_name' => $author_name]);
	}

	/**
	 * Store a newly created story in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$story = $this->story->fill(\Input::all());
		unset($story->author);
		$story->sort = $story->whereNull('issue_id')->max('sort') ?: 1;
		if ($story->validate()) {
			$story->save();
			return \Redirect::route('sysop.stories.index')->with('msg', "Story '{$story->title}' created.");
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.stories.create')->with('error', $story->errors);
	}

	/**
	 * Show the form for editing the specified story.
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
		if ($story->issue_id) {
			\Session::flash('error', 'A story assigned to an issue cannot be deleted.');
			$response = ['reload'=>\URL::route('sysop.stories.index')];
		}
		$story->delete();
		\Session::flash('msg', "'{$story->title}' deleted!");
		$response = ['redirect'=>\URL::route('sysop.stories.index')];
		return \Response::json($response);
	}

}
