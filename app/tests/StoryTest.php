<?php

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

}
