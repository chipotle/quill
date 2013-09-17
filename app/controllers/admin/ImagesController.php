<?php namespace Admin;

class ImagesController extends \BaseController {

	protected $image;

	function construct(\Image $image)
	{
		$this->image = $image;
	}

	/**
	 * Display a listing of the images.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Request::ajax()) {
			$images = $this->image->orderBy('updated_at', 'desc');
			return $images;
		} else {
			$images = $this->image->orderBy('updated_at', 'desc')->paginate(30);
			return \View::make('admin.images.index')->with('images', $images);
		}
	}

	/**
	 * Show the form for creating a new image.
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('admin.images.new')->with('image', $this->image);
	}

	/**
	 * Store a newly created image in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$image = $this->image;
		list($ok, $result) = $image->manage(Input::file('file'), Input::get('params'));
		if ($ok) {
			return \Redirect::route('sysop.images.index')->with('msg', 'Image uploaded.');
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.images.create')->with('error', $result);
	}


	/**
	 * Display the specified image.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$image = $this->image->findOrFail($id);
		return \View::make('admin.images.show')->with('image', $image);
	}

	/**
	 * Show the form for editing the specified image.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$image = $this->image->findOrFail($id);
		return \View::make('admin.images.edit')->with('images', $image);
	}

	/**
	 * Update the specified image in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$image = $this->image->findOrFail($id);
		if (Input::has('file')) {
			list($ok, $result) = $image->manage(Input::file('file'), Input::get('params'));
		} else {
			list($ok, $result) = $image->updateModel(Input::get('params'));
		}
		if ($ok) {
			return \Redirect::route('sysop.images.index')->with('msg', 'Image updated.');
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.images.edit')->with('error', $result);
	}

	/**
	 * Remove the specified image from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
