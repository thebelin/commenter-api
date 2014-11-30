<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('sites');
        Schema::create('sites', function(Blueprint $table)
        {
            // Local Keys
            $table->increments('id');
            $table->string('heading');

            // Foriegn Keys
            $table->integer('user_id');
            $table->foriegn('user_id')->references('id')->on('users');

            $table->timestamps();
        });	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
