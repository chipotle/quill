<?php namespace Admin;

class AuthorsController extends \BaseController {

	protected $author;

	protected $rules = [
		'name' => 'required',
		'show' => 'required|integer',
		'email' => 'email',
		'website' => 'url',
		'twitter' => 'alpha_dash',
	];

	function __construct(\Author $author)
	{
		$this->author = $author;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$authors = $this->author->orderBy('name', 'asc')->paginate(30);
		return \View::make('admin.authors.index')->with('authors', $authors);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$author = $this->author->findOrFail($id);
		return \View::make('admin.authors.show')->with('author', $author);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$author = $this->author;
		$author->show = \Author::SHOW_NAME;
		$user = \App::make('User');
		$userlist = $user->lists('username', 'id');
		$users = array_merge([null => '(None)'], $userlist);
		return \View::make('admin.authors.new')->with(['author' => $author, 'users' => $users]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = \Input::all();
		$author = $this->author;
		$validator = \Validator::make($input, $this->rules);
		if ($validator->fails()) {
			\Session::flashInput($input);
			return \Redirect::route('sysop.authors.create')->with('error', $validator->messages());
		}
		$author->fill($input);
		$author->save();
		return \Redirect::route('sysop.authors.index')->with('msg', "Author '{$author->name}' created.");
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$author = $this->author->findOrFail($id);
		return \View::make('admin.authors.edit')->with('author', $author);
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
		$author = $this->author->findOrFail($id);
		$validator = \Validator::make($input, $this->rules);
		if ($validator->fails()) {
			\Session::flashInput($input);
			return \Redirect::route('sysop.authors.edit', $author->id)->with('error', $validator->messages());
		}
		$author->fill($input);
		$author->save();
		return \Redirect::route('sysop.authors.index')->with('msg', "Author '{$author->name}' updated.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$author = $this->author->find($id);
		if (count($author->stories) > 0) {
			\Session::flash('error', "{$author->name} has stories in the database and cannot be deleted.");
			$response = ['reload'=>\URL::route('admin.authors.index')];
		}
		$author->delete();
		\Session::flash('msg', "{$author->name} deleted!");
		$response = ['redirect'=>\URL::route('admin.authors.index')];
		return \Response::json($response);
	}

}
