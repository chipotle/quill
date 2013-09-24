<?php

class Issue extends BaseModel {

	/**
	 * Database table used by model
	 */
	protected $table = 'issues';

	public static $rules = [
		'number' => 'required|numeric|min:1',
		'volume' => 'required|numeric|min:1',
		'pub_date' => 'required',
	];

	public function getDates()
	{
		return array_merge(parent::getDates(), ['pub_date']);
	}


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

	/**
	 * Return the volume and issue numbers of the current issue, defined as
	 * the highest issue number in the highest volume number.
	 *
	 * @return array
	 */
	public function getCurrentVolNum()
	{
		$vol = \DB::table('issues')->remember(60)->max('volume');
		if (empty($vol)) {
			$vol = $num = 0;
		}
		else {
			$num = \DB::table('issues')->where('volume', $vol)->
				remember(60)->max('number');
			if (empty($num)) $num = 0;
		}
		return [$vol, $num];
	}

	/**
	 * Return the current issue.
	 *
	 * @return Issue
	 */
	public function getCurrent()
	{
		list($vol, $num) = $this->getCurrentVolNum();
		if ($vol == 0 || $num == 0) return false;
		return $this->where('volume', $vol)->
			where('number', $num)->
			where('is_published', true)->
			remember(60)->
			first();
	}

}
