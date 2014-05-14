<?php
use Michelf\MarkdownExtra, Michelf\SmartyPants;

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
	public function stories()
	{
		return $this->hasMany('Story');
	}

	/**
	 * Author hasMany Pitches
	 */
	public function pitches()
	{
		return $this->hasMany('Pitch');
	}

    /**
     * Return the preferred name for an author object. Note that this is a
     * static class method, not an instance method.
     *
     * @param  Author $author
     * @throws UnexpectedValueException
     * @return string
     */
	static public function selectPreferredName($author)
	{
		switch ($author->show) {
			case Author::SHOW_NAME:
				$name = $author->name;
				break;
			case Author::SHOW_NICK:
				$name = $author->nickname;
				break;
			case Author::SHOW_BOTH:
				$name = "{$author->name} ({$author->nickname})";
				break;
			default:
				throw new UnexpectedValueException("Invalid show value of {$author->show} on Author {$author->id}");
				break;
		}
		return $name;
	}

	/**
	 * Return the preferred name for an author object. This is the instance
	 * method equivalent of selectPreferredName().
	 *
	 * @return string
	 */
	public function getPreferredName()
	{
		return self::selectPreferredName($this);
	}

	/**
	 * Return the author name in the form used by the story creation form.
	 *
	 * @return string
	 */
	public function getFormName()
	{
		return ($this->nickname) ? "{$this->name} ({$this->nickname})" : $this->name;
	}

	/**
	 * Get the HTML-ized bio field from the instance.
	 *
	 * @return string
	 */
	public function getBio()
	{
		$bio = MarkdownExtra::defaultTransform($this->bio);
		return SmartyPants::defaultTransform($bio);
	}

}
