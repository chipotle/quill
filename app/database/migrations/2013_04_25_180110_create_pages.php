<?php

use Illuminate\Database\Migrations\Migration;

class CreatePages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function($t)
		{
			$t->engine = 'InnoDB';
			$t->increments('id');
			$t->string('slug')->unique();
			$t->string('title');
			$t->text('body');
			$t->text('head')->nullable();
			$t->boolean('is_visible')->default(false);
			$t->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pages');
	}

}
