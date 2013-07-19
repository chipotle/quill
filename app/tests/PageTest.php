<?php
use Way\Tests\Factory;

class PageTest extends TestCase {

    public function testGetContent()
    {
    	$page = Factory::page([
    		'body' => "# Headline\n\n\"Lorem Ipsum,\" she said.\n",
    		'title' => "Bob's Test Page",
    		'head' => '<style> p { font-size: 48 pt } </style>'
    	]);

    	$expected = [
    		'title' => 'Bob&#8217;s Test Page',
    		'body' => "<h1>Headline</h1>\n\n<p>&#8220;Lorem Ipsum,&#8221; she said.</p>\n",
    		'head' => '<style> p { font-size: 48 pt } </style>'
    	];

    	$this->assertEquals($expected, $page->getContent());
    }

}
