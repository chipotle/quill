<?php

/**
 * Base model for Quill
 */
class BaseModel extends Eloquent {

	protected $guarded = ['id'];

	public $errors;

	public static $messages = array();

	/**
	 * Validate a model instance against the class rules, using the custom
	 * error messages if set.
	 *
	 * @return boolean
	 */
	public function validate()
	{
		$valid = Validator::make($this->attributes, static::$rules,
			static::$messages);
		if ($valid->passes()) {
			return true;
		}
		$this->errors = $valid->messages();
		return false;
	}

}
