<?php

class PitchController extends BaseController {

	protected $pitch;

	function __construct(Pitch $pitch)
	{
		$this->pitch = $pitch;
	}

	/**
	 * Validator for pitches
	 */
	protected $rules = [
		'email' => 'required|email',
		'name' => 'required',
		'blurb' => 'required'
	];

	public function getIndex()
	{
		return View::make('pitch')->with('pitch', $this->pitch);
	}

	public function postIndex()
	{
		$input = Input::all();
		$validator = Validator::make($input, $this->rules);
		if ($validator->fails()) {
			Session::flashInput($input);
			return Redirect::to('pitch')->with('error', $validator->messages());
		}
		$this->pitch->fill($input);
		$author = Author::where('email', $this->pitch->email)->first();
		if ($author) $this->pitch->author_id = $author->id;
		$this->pitch->save();
		Queue::push('PitchNotify', ['pitch' => $this->pitch->id]);
		return View::make('gotpitch')->with('pitch', $this->pitch);
	}
}
