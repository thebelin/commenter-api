<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration {

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
            $table->string('hostUrl');

            // Foriegn Keys
            $table->integer('thread_id');
            $table->foriegn('thread_id')->references('id')->on('threads');

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
