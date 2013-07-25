<?php namespace Admin;

class AuthorsController extends \BaseController {

	protected $author;

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
		return \View::make('admin.authors.new')->with('author', $author);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$author = $this->author->fill(\Input::all());
		if ($author->validate()) {
			$author->save();
			return \Redirect::route('sysop.authors.index')->with('msg', "Author '{$author->name}' created.");
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.authors.create')->with('error', $author->errors);
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
		$author = $this->author->findOrFail($id);
		$author->fill(\Input::all());
		if ($author->validate()) {
			$author->save();
			return \Redirect::route('sysop.authors.index')->with('msg', "Author '{$author->name}' updated.");
		}
		\Session::flashInput($author->getAttributes());
		return \Redirect::route('sysop.authors.edit')->with('error', $author->errors);
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
