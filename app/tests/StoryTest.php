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

	public function testGetBlurb()
	{
		$story = Factory::make('story', ['blurb' => 'Lorem ipsum dolor sit amet']);
		$return = "<p>Lorem ipsum dolor sit amet</p>\n";
		$this->assertEquals($return, $story->getBlurb());
	}

	public function testGetBody()
	{
		$story = Factory::make('story', ['body' => 'Lorem ipsum dolor sit amet']);
		$return = "<p>Lorem ipsum dolor sit amet</p>\n";
		$this->assertEquals($return, $story->getBody());
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
			'author_id' => $story->author_id,
			'subhead' => $story->subhead,
			'id' => 'x',
			'volnum' => 1,
			'issue_id' => 1,
			'slug' => 'foo-bar',
			'date' => 'Sep 15, 2013'
		];
		$this->assertEquals($return, $story->getContent());
	}

	public function testAutoBlurb()
	{
		$story = Factory::make('story', [
			'body' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Itaque sensibus rationem adiunxit et ratione effecta sensus non reliquit. Tum mihi Piso: Quid ergo? Nihil ad rem! Ne sit sane; Tum Piso: Quoniam igitur aliquid omnes, quid Lucius noster?\n\nIllud mihi a te nimium festinanter dictum videtur, sapientis omnis esse semper beatos; Memini vero, inquam; Eaedem enim utilitates poterunt eas labefactare atque pervertere. At certe gravius. Stoicos roga. Hic ambiguo ludimur. Nam de isto magna dissensio est. Huius, Lyco, oratione locuples, rebus ipsis ielunior.\n\nDuo Reges: constructio interrete. Nosti, credo, illud: Nemo pius est, qui pietatem-; Praeclare enim Plato: Beatum, cui etiam in senectute contigerit, ut sapientiam verasque opiniones assequi possit. Quam ob rem tandem, inquit, non satisfacit? Expectoque quid ad id, quod quaerebam, respondeas. Nunc haec primum fortasse audientis servire debemus."
		]);
		$return = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Itaque sensibus rationem adiunxit et ratione effecta sensus non reliquit. Tum mihi Piso: Quid ergo? Nihil ad rem! Ne sit sane; Tum Piso: Quoniam igitur aliquid omnes, quid Lucius noster?</p>\n";
		$this->assertEquals($return, $story->autoBlurb());
	}

}
