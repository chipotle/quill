<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropSortIndexesFromStories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stories', function(Blueprint $table) {
			$table->dropIndex('stories_sort_issue_id_unique');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stories', function(Blueprint $table) {
			$table->unique(['sort', 'issue_id']);
		});
	}

}
