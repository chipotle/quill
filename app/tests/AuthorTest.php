<?php
use Way\Tests\Factory;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class AuthorTest extends TestCase {
	use Way\Tests\ModelHelpers;

	public function testBelongsToUser()
	{
		$this->assertBelongsTo('user', 'Author');
	}

	public function testHasManyStories()
	{
		$this->assertHasMany('stories', 'Author');
	}

	public function testHasManyPitches()
	{
		$this->assertHasMany('pitches', 'Author');
	}

	public function testMustHaveName()
	{
		$author = Factory::make('author');
		$author->name = null;
		$this->assertNotValid($author);
	}

	public function testMustHaveValidEmail()
	{
		$author = Factory::make('author');
		$author->email = 'bad-email';
		$this->assertNotValid($author);
	}

	public function testMustHaveValidWebsite()
	{
		$author = Factory::make('author');
		$author->website = 'bad-website';
		$this->assertNotValid($author);
	}

	public function testMustHaveValidTwitter()
	{
		$author = Factory::make('author');
		$author->twitter = 'bad twitter';
		$this->assertNotValid($author);
	}

	public function testPreferredNameShowName()
	{
		$author = Factory::make('author');
		$author->show = Author::SHOW_NAME;
		$this->assertEquals($author->name, $author->getPreferredName());
	}

	public function testPreferredNameShowNick()
	{
		$author = Factory::make('author');
		$author->show = Author::SHOW_NICK;
		$this->assertEquals($author->nickname, $author->getPreferredName());
	}

	public function testPreferredNameShowBoth()
	{
		$author = Factory::make('author');
		$author->show = Author::SHOW_BOTH;
		$expected = "{$author->name} ({$author->nickname})";
		$this->assertEquals($expected, $author->getPreferredName());
	}

	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testPreferredNameException()
	{
		$author = Factory::make('author');
		$author->show = 42;
		$foo = $author->getPreferredName();
	}

	public function testGetFormName()
	{
		$author = Factory::make('author');
		$expected = "{$author->name} ({$author->nickname})";
		$this->assertEquals($expected, $author->getFormName());
		$author->nickname = null;
		$expected = $author->name;
		$this->assertEquals($expected, $author->getFormName());
	}

	public function testGetBio()
	{
		$author = Factory::make('author', [
			'bio' => 'Lorem ipsum--blah *blah* blah']);
		$expected =  "<p>Lorem ipsum&#8212;blah <em>blah</em> blah</p>\n";
		$this->assertEquals($expected, $author->getBio());
	}

}
