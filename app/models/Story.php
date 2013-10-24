<?php
use Michelf\MarkdownExtra, Chipotle\Smartypants;

class Story extends BaseModel {

	/**
	 * Database table used by model
	 */
	protected $table = 'stories';

	public static $rules = [
		'title' => 'required',
		'slug' => 'required:size:4|alpha_dash',
		'body' => 'required',
		'author_id' => 'required|exists:authors,id'
	];

	public static $messages = [
		'author_id.required' => 'The author field is required.'
	];

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
	 * Story hasMany Images (polymorphic)
	 */
	public function images()
	{
		return $this->morphMany('Images', 'imageable');
	}

	/**
	 * Register event listener to clear cache on model save
	 */
	public static function boot()
	{
		parent::boot();

		static::saving(function($story) {
			Cache::forget("story-{$story->id}");
		});
	}

	/**
	 * Retrieve Markdownified blurb
	 *
	 * @return string
	 */
	public function getBlurb()
	{
		if (empty($this->blurb)) return '';
		$blurb = MarkdownExtra::defaultTransform($this->blurb);
		return Smartypants::defaultTransform($blurb);
	}

	/**
	 * Retrieve Markdownified content, from cache if appropriate
	 *
	 * @return string
	 */
	public function getContent()
	{
		$content = Cache::rememberForever("story-{$this->id}", function() {
			$blurb = $this->getBlurb();
			$body = MarkdownExtra::defaultTransform($this->body);
			$body = Smartypants::defaultTransform($body);
			$title = Smartypants::defaultTransform($this->title);
			return [
				'title' => $title,
				'body' => $body,
				'blurb' => $blurb,
				'author' => $this->author->getPreferredName(),
				'author_id' => $this->author_id,
				'subhead' => $this->subhead,
				'id' => $this->id,
				'slug' => $this->slug,
				'issue_id' => ($this->issue_id) ? $this->issue_id : 0,
				'volnum' => ($this->issue_id) ? $this->issue->number : 0,
				'date' => ($this->issue_id) ?
					$this->issue->pub_date->toFormattedDateString() :
					\Carbon\Carbon::now()->toFormattedDateString()
			];
		});
		return $content;
	}

}
