<?php namespace Admin;

class ImagesController extends \BaseController {

	protected $image;

	function __construct(\Image $image)
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
		if (\Request::ajax()) {
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
		$file = \Input::file('file');
		if ($file === null) {
			return \Redirect::route('sysop.images.create')->with('msg', 'No file given');
		}
		$image = $this->image;
		$retina = $image->updateModel(\Input::get('params'));
		$ok = $image->updateFile($file, $retina);
		if ($ok) {
			$image->save();
			return \Redirect::route('sysop.images.index')->with('msg', 'Image uploaded.');
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.images.create')->with('msg', 'Error uploading file.');
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
		return \View::make('admin.images.edit')->with('image', $image);
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
		$retina = $image->updateModel(\Input::get('params'));
		$file = \Input::file('file');
		if ($file !== null) {
			$ok = $image->updateFile($file, $retina);
		} else {
			$ok = true;
		}
		if ($ok) {
			$image->save();
			return \Redirect::route('sysop.images.index')->with('msg', 'Image updated.');
		}
		\Session::flashInput(\Input::all());
		return \Redirect::route('sysop.images.edit')->with('msg', 'Error uploading file.');
	}

	/**
	 * Remove the specified image from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$image = $this->image->findOrFail($id);
		$del_retina = @unlink($image->getFilePath(true));
		$ok = @unlink($image->getFilePath());
		if (! $ok) {
			\Session::flash('error', "File for {$image->name} cannot be found on disk!");
			$response = ['reload'=>\URL::route('sysop.images.index')];
		}
		$image->delete();
		\Session::flash('msg', "{$image->name} deleted!");
		$response = ['redirect'=>\URL::route('sysop.images.index')];
		return \Response::json($response);
	}

}
