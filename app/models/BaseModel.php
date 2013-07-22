<?php

/**
 * Base model for Quill
 */
class BaseModel extends Eloquent {

	protected $guarded = ['id'];

	public $errors;

	public function validate()
	{
		$v = Validator::make($this->attributes, static::$rules);
		if ($v->passes()) return true;
		$this->errors = $v->messages();
		return false;
	}

}
