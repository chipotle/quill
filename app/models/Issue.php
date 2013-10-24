<?php

class Issue extends BaseModel {

	/**
	 * Database table used by model
	 */
	protected $table = 'issues';

	public static $rules = [
		'number' => 'required|numeric|min:1',
		'pub_date' => 'required',
	];

	/**
	 * Add 'pub_date' field to the list of fields to be converted to Carbon
	 *
	 * @return array
	 */
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

	public function storiesSorted()
	{
		$this->load('stories.author');
		return $this->stories->sortBy(function($s) {
			return $s->sort;
		});
	}

	/**
	 * Issue hasMany Images (polymorphic)
	 */
	public function images()
	{
		return $this->morphMany('Images', 'imageable');
	}

	/**
	 * Return the highest issue number in the database, published or not.
	 *
	 * @return array
	 */
	public function getCurrentNum()
	{
		$num = \DB::table('issues')->remember(60)->max('number');
		if (empty($num)) $num = 0;
		return $num;
	}

	/**
	 * Get a list of most recent published issues
	 * @param integer $limit # of issues to return
	 * @return Array of Issue objects
	 */
	public function getPublishedIssues($limit=3)
	{
		return $this->where('is_published', true)->orderBy('number', 'desc')->take($limit)->get();
	}

	/**
	 * Return the current (published) issue.
	 *
	 * @return Issue
	 */
	public function getCurrent()
	{
		return $this->where('is_published', true)->orderBy('number', 'desc')->first();
	}

}
