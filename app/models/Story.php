<?php

class Story extends Eloquent {

	/**
	 * Database table used by model
	 */
	protected $table = 'stories';

	protected $guarded = ['id'];

	/**
	 * Story belongsTo Issue
	 */
	function issue()
	{
		return $this->belongsTo('Issue');
	}

	/**
	 * Story belongsTo Author
	 */
	function author()
	{
		return $this->belongsTo('Author');
	}

	/**
	 * Story hasOne Pitch
	 */
	function pitch()
	{
		return $this->hasOne('Pitch');
	}

	/**
	 * Register event listener to clear cache on model save
	 */
	public static function boot()
	{
		parent::boot();

		self::saving(function($story) {
			\Cache::forget("story-{$story->id}");
		});
	}

	public function getContent()
	{
		$content = Cache::rememberForever("story-{$this->id}", function() {
			$blurb = MarkdownExtra::defaultTransform($this->blurb);
			$blurb = Smartypants::defaultTransform($blurb);
			$body = MarkdownExtra::defaultTransform($this->body);
			$body = Smartypants::defaultTransform($body);
			$title = Smartypants::defaultTransform($this->title);
			return ['title' => $title, 'body' => $body,
					'blurb' => $this->blurb];
		});
		return $content;
	}

}
