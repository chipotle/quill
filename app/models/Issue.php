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

	public function getLast($published=true)
	{
		$vol = \DB::table('issues')->max('volume');
		if (empty($vol)) {
			$vol = $num = 0;
		}
		else {
			$num = \DB::table('issues')->where('volume', $vol)->
				max('number');
			if (empty($num)) $num = 0;
		}
		if ($published) {
			if ($vol == 0 || $num == 0) return false;
			return $this->where('volume', $vol)->
				where('number', $num)->
				where('is_published', true)->
				first();
		}
		return [$vol, $num];
	}

}
