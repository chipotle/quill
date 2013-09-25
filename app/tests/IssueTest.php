<?php
use Way\Tests\Factory;

class IssueTest extends TestCase {
	use Way\Tests\ModelHelpers;

	public function testHasManyStories()
	{
		$this->assertHasMany('stories', 'Issue');
	}

	public function testHasManyImages()
	{
		$this->assertRespondsTo('images', 'Issue');
		$class = Mockery::mock('Issue[morphMany]');
		$class->shouldReceive('morphMany')->with('Images', 'imageable')->once();
		$class->images();
	}

}
