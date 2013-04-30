<?php

use Illuminate\Database\Migrations\Migration;

class CreateAuthors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('authors', function($t)
		{
			$t->engine = 'InnoDB';
			$t->increments('id');
			$t->string('name');
			$t->string('nickname')->nullable();
			$t->integer('show')->unsigned()->default(Author::SHOW_NAME);
			$t->string('email')->nullable()->index();
			$t->string('website')->nullable();
			$t->string('twitter')->nullable();
			$t->text('bio')->nullable();
			$t->integer('user_id')->unsigned()->nullable();
			$t->timestamps();

			$t->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('authors', function($t)
		{
			$t->dropForeign('authors_user_id_foreign');
		});
	}

}
