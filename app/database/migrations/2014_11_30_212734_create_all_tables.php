<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drops        
        Schema::dropIfExists('users');
        Schema::dropIfExists('threads');
        Schema::dropIfExists('sites');
        Schema::dropIfExists('messages');        
        
        // Creation Schema for application tables
        Schema::create('users', function(Blueprint $table)
        {
            // Define Fields
            $table->increments('id', true);
            $table->timestamps();
            $table->string('email');
            $table->string('password');

            // Define index
            $table->index('email', 'password');
        });

        Schema::create('threads', function(Blueprint $table)
        {
            // Define Fields
            $table->increments('id');
            $table->timestamps();
            $table->string('heading');
            $table->integer('user_id')->unsigned();

            // Define Index
            $table->index('heading');
        });

        Schema::create('sites', function(Blueprint $table)
        {
            // Fields
            $table->increments('id');
            $table->timestamps();
            $table->string('hostUrl');
            $table->integer('thread_id')->unsigned();
        });


        Schema::create('messages', function(Blueprint $table)
        {
            // Fields
            $table->increments('id');
            $table->timestamps();
            $table->string('email');
            $table->string('message');
            $table->string('gravatar');
            $table->integer('thread_id')->unsigned();

            // Keys
            $table->index('thread_id');
        });

        // Create Foreign Keys
        Schema::table('threads', function(Blueprint $table)
        {
           $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('sites', function(Blueprint $table)
        {
            $table->foreign('thread_id')->references('id')->on('threads');
        });

        Schema::table('messages', function(Blueprint $table)
        {
            $table->foreign('thread_id')->references('id')->on('threads');
        });
    }

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
