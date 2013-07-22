<?php

class Author extends Eloquent {

	/**
	 * Database table used by model
	 */
	protected $table = 'authors';

	protected $guarded = ['id'];

	/**
	 * Class Constants
	 */

	const SHOW_NAME = 10;
	const SHOW_NICK = 20;
	const SHOW_BOTH = 30;

	/**
	 * Author belongsTo User
	 */
		public function user()
	{
		return $this->belongsTo('User');
	}

	/**
	 * Author hasMany Stories
	 */
	function stories()
	{
		return $this->hasMany('Story');
	}

	/**
	 * Author hasMany Pitches
	 */
	function pitches()
	{
		return $this->hasMany('Pitch');
	}

}
