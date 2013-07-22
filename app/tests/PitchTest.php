<?php
use Way\Tests\Factory;

class PitchTest extends TestCase {
	use Way\Tests\ModelHelpers;

	public function testBelongsToAuthor()
	{
		$this->assertBelongsTo('author', 'Pitch');
	}

	public function testBelongsToStory()
	{
		$this->assertBelongsTo('story', 'Pitch');
	}

	public function testMustHaveName()
	{
		$pitch = Factory::make('pitch');
		$pitch->name = null;
		$this->assertNotValid($pitch);
	}

	public function testMustHaveBlurb()
	{
		$pitch = Factory::make('pitch');
		$pitch->blurb = null;
		$this->assertNotValid($pitch);
	}

	public function testMustHaveValidEmail()
	{
		$pitch = Factory::make('pitch');
		$pitch->email = 'bad-email';
		$this->assertNotValid($pitch);
	}

}
