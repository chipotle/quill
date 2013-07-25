<?php

class Author extends BaseModel {

	/**
	 * Database table used by model
	 */
	protected $table = 'authors';

	public static $rules = [
		'name' => 'required',
		'show' => 'required|integer',
		'email' => 'email',
		'website' => 'url',
		'twitter' => 'alpha_dash',
	];

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

	function getPreferredName()
	{
		switch ($this->show) {
			case Author::SHOW_NAME:
				$name = $this->name;
				break;
			case Author::SHOW_NICK:
				$name = $this->nickname;
				break;
			case Author::SHOW_BOTH:
				$name = "{$this->nickname} ({$this->name})";
				break;
			default:
				throw new UnexpectedValueException("Invalid show value of {$this->show} on Author {$this->id}");
				break;
		}
		return $name;
	}

}
