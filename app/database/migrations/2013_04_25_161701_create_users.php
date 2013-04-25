<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($t)
		{
			$t->engine = 'InnoDB';
			$t->increments('id');
			$t->string('username')->unique();
			$t->string('email');
			$t->string('password');
			$t->boolean('is_admin')->default(false);
			$t->boolean('is_active')->default(true);
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
		Schema::drop('users');
	}

}
