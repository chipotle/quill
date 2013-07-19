<?php

class StoryTest extends TestCase {
	use Way\Tests\ModelHelpers;

    public function testBelongsToIssue()
    {
    	$this->assertBelongsTo('issue', 'Story');
    }

}
