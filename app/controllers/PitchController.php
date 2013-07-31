<?php

class PitchController extends BaseController {

	protected $pitch;

	function __construct(Pitch $pitch)
	{
		$this->pitch = $pitch;
	}

	public function getIndex()
	{
		return View::make('pitch')->with('pitch', $this->pitch);
	}

	public function postIndex()
	{
		$pitch = $this->pitch->fill(Input::all());
		if ($pitch->validate()) {
			$author = Author::where('email', $pitch->email)->first();
			if ($author) $pitch->author_id = $author->id;
			$pitch->save();
			Queue::push('PitchNotify', ['pitch' => $pitch->id]);
			return View::make('gotpitch')->with('pitch', $pitch);
		}
		Session::flashInput(Input::all());
		return Redirect::to('pitch')->with('error', $pitch->errors);
	}
}
