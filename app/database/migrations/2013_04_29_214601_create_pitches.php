<?php

use Illuminate\Database\Migrations\Migration;

class CreatePitches extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pitches', function($t)
		{
			$t->engine = 'InnoDB';
			$t->increments('id');
			$t->string('email');
			$t->string('name');
			$t->text('blurb');
			$t->text('notes')->nullable();
			$t->integer('status')->default(Pitch::UNSEEN)->unsigned();
			$t->integer('author_id')->unsigned()->nullable();
			$t->integer('story_id')->unsigned()->nullable();
			$t->timestamps();

			$t->foreign('author_id')->references('id')->on('authors');
			$t->foreign('story_id')->references('id')->on('stories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pitches', function($t)
		{
			$t->drop_foreign('pitches_author_id_foreign');
			$t->drop_foreign('pitches_story_id_foreign');
		});
	}

}
