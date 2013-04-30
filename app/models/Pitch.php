<?php

class Pitch extends Eloquent {

	protected $table = 'pitches';

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
	function author()
	{
		return $this->belongsTo('Author');
	}

	/**
	 * Pitch belongsTo Story
	 */
	function story()
	{
		return $this->belongsTo('Story');
	}

}
