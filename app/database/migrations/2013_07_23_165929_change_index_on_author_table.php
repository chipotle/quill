<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeIndexOnAuthorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authors', function(Blueprint $table) {
        	$table->dropForeign('authors_user_id_foreign');
        	$table->dropIndex('authors_user_id_foreign');
        	$table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authors', function(Blueprint $table) {
			$table->integer('user_id')->unsigned()->nullable();

			$table->foreign('user_id')->references('id')->on('users');
        });
    }

}
