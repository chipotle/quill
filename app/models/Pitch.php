<?php

class Pitch extends BaseModel {

	protected $table = 'pitches';

	public static $rules = [
		'email' => 'required|email',
		'name' => 'required',
		'blurb' => 'required'
	];

	/**
	 * Class constants
	 */
	const UNSEEN    = 10;
	const REVIEW    = 20;
	const REJECTED  = 30;
	const ACCEPTED  = 40;
	const WAITING   = 60;
	const PUBLISHED = 70;

	static public $statusList = [
		Pitch::UNSEEN    => 'Unseen',
		Pitch::REVIEW    => 'In Review',
		Pitch::REJECTED  => 'Rejected',
		Pitch::ACCEPTED  => 'Accepted',
		Pitch::WAITING   => 'Waiting for Rev',
		Pitch::PUBLISHED => 'Published'
	];
	/**
	 * Pitch belongsTo Author
	 */
	public function author()
	{
		return $this->belongsTo('Author');
	}

	/**
	 * Pitch belongsTo Story
	 */
	public function story()
	{
		return $this->belongsTo('Story');
	}

	public function scopePending($query)
	{
		return $query->whereIn('status', [
			Pitch::UNSEEN,
			Pitch::REVIEW,
			Pitch::ACCEPTED,
			Pitch::WAITING
		]);
	}

}
