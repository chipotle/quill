<?php

class PitchController extends BaseController {

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
		$pitch = new Pitch();
		return View::make('pitch')->with('pitch', $pitch);
	}

	public function postIndex()
	{
		$input = Input::all();
		$pitch = new Pitch();
		$validator = Validator::make($input, $this->rules);
		if ($validator->fails()) {
			Session::flashInput($input);
			return Redirect::to('pitch')->with('error', $validator->messages());
		}
		$pitch->fill($input);
		$author = Author::where('email', $pitch->email)->first();
		if ($author) $pitch->author_id = $author->id;
		$pitch->save();
		Queue::push('PitchNotify', ['pitch' => $pitch->id]);
		return View::make('gotpitch')->with('pitch', $pitch);
	}
}
