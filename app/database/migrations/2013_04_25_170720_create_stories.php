<?php

use Illuminate\Database\Migrations\Migration;

class CreateStories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stories', function($t)
		{
			$t->engine = 'InnoDB';
			$t->increments('id');
			$t->integer('author_id')->unsigned();
			$t->integer('issue_id')->unsigned();
			$t->text('body');
			$t->text('blurb');
			$t->boolean('is_published')->default(false);
			$t->timestamps();

			$t->foreign('author_id')->references('id')->on('authors');
			$t->foreign('issue_id')->references('id')->on('issues');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stories', function($t)
		{
			$t->dropForeign('stories_author_id_foreign');
			$t->dropForeign('stories_issue_id_foreign');
		});
	}

}
