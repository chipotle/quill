<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSlugToStoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stories', function(Blueprint $table) {
            $table->string('slug');
            $table->unique(['issue_id', 'slug']);
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
        	$table->dropIndex('stories_issue_id_slug_unique');
        	$table->dropColumn('slug');
        });
    }

}
