<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::dropIfExists('messages');
        Schema::create('messages', function(Blueprint $table)
        {
            // Local Keys
            $table->increments('id');
            $table->string('email');
            $table->string('message');
            $table->string('gravatar');

            // Foriegn Keys
            $table->integer('thread_id');
            $table->foriegn('thread_id')->references('id')->on('threads');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function(Blueprint $table)
        {
            //
        });
    }

}
