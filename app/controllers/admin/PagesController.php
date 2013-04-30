<?php
use Michelf\Markdown, Chipotle\Smartypants;

class Admin_PagesController extends BaseController {

	/**
	 * Validator array for pages
	 */
	protected $rules = [
		'title' => 'required',
		'slug' => 'required:size:4|alpha_dash',
		'body' => 'required'
	];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = Page::all();
		return View::make('admin.pages.index')->with(['pages' => $pages]);
	}

	/**
	 * Show new/edit form, depending on calling resource
	 * 
	 * @return Response
	 */
	private function editForm($id=false)
	{
		if ($id) {
			$page = Page::find($id);
			$content = [
				'title' => "Editing Page '{$page->slug}'",
				'url' => URL::route('sysop.pages.update', [$page->id]),
				'page' => $page,
				'method' => 'put' 
			];
		}
		else {
			$page = new Page();
			$content = [
				'title' => 'New Page',
				'url' => URL::route('sysop.pages.store'),
				'page' => $page,
				'method' => 'post' 
			];
		}
		return View::make('admin.pages.new')->with($content);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->editForm();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$page = new Page();
		$validator = Validator::make($input, $this->rules);
		if ($validator->fails()) {
			return Redirect::route('sysop.pages.create')->with('error', $validator->messages());
		}
		$page->fill($input);
		$page->save();
		return Redirect::route('sysop.pages.index')->with('msg', "Page '{$page->slug}' created.");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$page = Page::find($id);
		$body = Markdown::defaultTransform($page->body);
		$content = [
			'body' => Smartypants::defaultTransform($body),
			'title' => Smartypants::defaultTransform($page->title),
			'id' => $page->id
		];
		return View::make('admin.pages.show')->with($content);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->editForm($id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$page = Page::find($id);
		$validator = Validator::make($input, $this->rules);
		if ($validator->fails()) {
			return Redirect::route('sysop.pages.edit', [$id])->with('error', $validator->messages());
		}
		$page->fill($input);
		$page->save();
		Cache::forget("page-{$page->id}");
		return Redirect::route('sysop.pages.index')->with('msg', "Page '{$page->slug}' updated.");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$page = Page::find($id);
		$slug = $page->slug;
		$page->delete();
		Session::flash('msg', "Page '$slug' deleted!");
		$response = ['redirect'=>URL::route('sysop.pages.index')];
		return Response::json($response);
	}

}