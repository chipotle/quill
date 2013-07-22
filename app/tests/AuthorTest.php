<?php

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

}
