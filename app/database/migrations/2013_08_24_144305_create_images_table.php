<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
			$table->increments('id');
			$table->string('path');
			$table->string('name');
			$table->integer('imageable_id')->unsigned();
			$table->string('imageable_type');
			$table->string('caption')->nullable();
			$table->string('alt_text')->nullable();
			$table->timestamps();

			$table->index(['imageable_id', 'imageable_type']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('images');
	}

}
