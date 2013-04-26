<?php

use Illuminate\Database\Migrations\Migration;

class CreateIssues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issues', function($t)
		{
			$t->engine = 'InnoDB';
			$t->increments('id');
			$t->integer('number')->unsigned();
			$t->integer('volume')->unsigned()->default(1);
			$t->string('title')->nullable();
			$t->date('pub_date');
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
		Schema::drop('issues');
	}

}
