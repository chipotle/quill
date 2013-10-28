<?php

class ContactController extends BaseController {

	/**
	 * Get the "contact us" template.
	 *
	 * @return View response object
	 */
	public function getIndex()
	{
		return View::make('contact');
	}

	/**
	 * Save a message returned via POST.
	 *
	 * @return View response object
	 */
	public function postIndex()
	{
		$return = Input::all();
		$rules = ['name' => 'required', 'email' => 'email', 'body' => 'required|min:8'];
		$messages = ['body.required' => 'You must type a message.', 'body.min' => 'Cat got your tongue? (You must write more than that.)'];
		$validator = Validator::make($return, $rules, $messages);
		if ($validator->fails()) {
			Session::flashInput($return);
			return Redirect::to('contact')->with('error', $validator->messages());
		}
		Queue::push('ContactNotify', $return);
		return View::make('gotcontact')->with('name', $return['name']);
	}
}
