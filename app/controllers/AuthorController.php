<?php

class AuthorController extends BaseController {

	protected $author;

	function __construct(Author $author, Story $story)
	{
		$this->author = $author;
		$this->story = $story;
	}

	/**
	 * Present the paginated list of authors.
	 *
	 * @return View response
	 */
	function getIndex()
	{
		$authors = DB::table('authors')->select('authors.id', 'authors.name', 'authors.show', 'authors.nickname', 'authors.email', DB::raw('CASE WHEN `show`='.Author::SHOW_NICK.' THEN nickname ELSE name END as \'preferred\''))->join('stories', 'authors.id', '=', 'stories.author_id')->distinct()->where('stories.issue_id', '>', '0')->orderBy('preferred', 'asc')->paginate(30);
		$stories = [];
		$names = [];
		foreach ($authors as $author) {
			$stories[$author->id] = $this->story->where('author_id', $author->id)->where('issue_id', '>', 0)->orderBy('issue_id')->get();
			$names[$author->id] = Author::selectPreferredName($author);
		}
		return View::make('authors.index')->with(['authors'=>$authors, 'stories'=>$stories, 'names'=>$names]);
	}

	/**
	 * Show an author biography.
	 *
	 * @param  int $id
	 * @return View response
	 */
	function showBio($id)
	{
		$author = $this->author->with(['stories.issue', 'stories' => function($q) {
			$q->where('issue_id', '>', 0);
		}])->findOrFail($id);
		return View::make('authors.bio')->with('author', $author);
	}
}
