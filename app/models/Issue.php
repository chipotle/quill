<?php

class Issue extends BaseModel {

	/**
	 * Database table used by model
	 */
	protected $table = 'issues';

	public static $rules = [
		'number' => 'required|numeric|min:1',
		'volume' => 'required|numeric|min:1',
		'pub_date' => 'required|date_format:Y-m-d',
	];

	/**
	 * Issue hasMany Stories
	 */
	public function stories()
	{
		return $this->hasMany('Story');
	}

	/**
	 * Issue hasMany Images (polymorphic)
	 */
	public function images()
	{
		return $this->morphMany('Images', 'imageable');
	}

	/**
	 * Return the volume and number of this issue *or* just the issue number
	 * if Quill is not using volumes.
	 *
	 * @return string
	 */
	public function volnum()
	{
		return (Config::get('quill.use_volumes') ? "{$this->volume}.{$this->number}" : $this->number);
	}

}
