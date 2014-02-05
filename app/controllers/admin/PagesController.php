<?php namespace Admin;

use Michelf\MarkdownExtra, Michelf\SmartyPants;

class PagesController extends \BaseController {

	protected $page;

	function __construct(\Page $page)
	{
		$this->page = $page;
	}

	/**
	 * Display a listing of the pages.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = $this->page->all();
		return \View::make('admin.pages.index')->with(['pages' => $pages]);
	}

	/**
	 * Show the form for creating a new page.
	 *
	 * @return Response
	 */
	public function create()
	{
		$page = $this->page;
		return \View::make('admin.pages.new')->with('page', $page);
	}

	/**
	 * Store a newly created page in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$page = $this->page->fill(\Input::all());
		if ($page->validate()) {
			$page->save();
			return \Redirect::route('sysop.pages.index')->with('msg', "Page '{$page->slug}' created.");
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.pages.create')->with('error', $page->errors);
	}

	/**
	 * Display the specified page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$page = $this->page->find($id);
		$body = MarkdownExtra::defaultTransform($page->body);
		$content = [
			'body' => SmartyPants::defaultTransform($body),
			'title' => SmartyPants::defaultTransform($page->title),
			'id' => $page->id
		];
		return \View::make('admin.pages.show')->with($content);
	}

	/**
	 * Show the form for editing the specified page.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$page = $this->page->findOrFail($id);
		return \View::make('admin.pages.edit')->with('page', $page);
	}

	/**
	 * Update the specified page in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$page = $this->page->findOrFail($id);
		$page->fill(\Input::all());
		if ($page->validate()) {
			$page->save();
			return \Redirect::route('sysop.pages.index')->with('msg', "Page '{$page->slug}' updated.");
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.pages.edit')->with('error', $page->errors);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$page = $this->page->find($id);
		$slug = $page->slug;
		$page->delete();
		\Session::flash('msg', "Page '$slug' deleted!");
		$response = ['redirect'=>\URL::route('sysop.pages.index')];
		return \Response::json($response);
	}

}
