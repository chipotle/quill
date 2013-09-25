<?php
use Way\Tests\Factory, \Carbon\Carbon;

class StoryTest extends TestCase {
	use Way\Tests\ModelHelpers;

	public function testBelongsToIssue()
	{
		$this->assertBelongsTo('issue', 'Story');
	}

	public function testBelongsToAuthor()
	{
		$this->assertBelongsTo('author', 'Story');
	}

	public function testHasOnePitch()
	{
		$this->assertHasOne('pitch', 'Story');
	}

	public function testHasManyImages()
	{
		$this->assertRespondsTo('images', 'Story');
		$class = Mockery::mock('Story[morphMany]');
		$class->shouldReceive('morphMany')->with('Images', 'imageable')->once();
		$class->images();
	}

	public function testGetContent()
	{
		Cache::forget('story-x');
		$author = Factory::make('author');
		$author->show = Author::SHOW_NICK;
		$issue = Factory::make('issue');
		$issue->pub_date = Carbon::createFromDate(2013, 9, 15);
		$issue->number = 1;
		$story = Factory::make('story', [
			'author' => $author,
			'id' => 'x',
			'blurb' => 'This is a "thing"',
			'body' => "Lorem _ipsum_ dolor amet\n\nLorem--ipsum",
			'title' => "Big 'thing'",
			'issue_id' => 1,
			'slug' => 'foo-bar',
			'issue' => $issue
		]);
		$return = [
			'blurb' => "<p>This is a &#8220;thing&#8221;</p>\n",
			'body' => "<p>Lorem <em>ipsum</em> dolor amet</p>\n\n<p>Lorem&#8212;ipsum</p>\n",
			'title' => "Big &#8216;thing&#8217;",
			'author' => $author->nickname,
			'subhead' => $story->subhead,
			'id' => 'x',
			'volnum' => 1,
			'issue_id' => 1,
			'slug' => 'foo-bar',
			'date' => 'Sep 15, 2013'
		];
		$this->assertEquals($return, $story->getContent());
	}

}
