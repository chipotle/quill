<?php
use Michelf\MarkdownExtra, Michelf\SmartyPants;

class Page extends BaseModel {

	/**
	 * Database table used by model
	 */
	protected $table = 'pages';

	/**
	 * Validation rules
	 */
	public static $rules = [
		'title' => 'required',
		'slug' => 'required:size:4|alpha_dash',
		'body' => 'required'
	];

	/**
	 * Register event listener to clear cache on model save
	 */
	public static function boot()
	{
		parent::boot();

		static::saving(function($page) {
			Cache::forget("page-{$page->id}");
		});
	}

	/**
	 * Retrieve Markdownified content, from cache if appropriate
	 */
	public function getContent()
	{
		$content = Cache::rememberForever("page-{$this->id}", function() {
			$body = MarkdownExtra::defaultTransform($this->body);
			$body = SmartyPants::defaultTransform($body);
			$title = SmartyPants::defaultTransform($this->title);
			return ['title' => $title, 'body' => $body,
					'head' => $this->head];
		});
		return $content;
	}
}
