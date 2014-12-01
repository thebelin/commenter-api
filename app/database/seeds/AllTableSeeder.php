<?php
 
class AllTableSeeder extends Seeder {
 
    public function run()
    {
        // Create the new test user
        $userObj = new User;
        $userObj->username = 'testUser';
        $userObj->password = Hash::make('secret');
        $userObj->save();
        // The id of the new object will be used in the next insert
        $userId = $userObj->id;

        // THREADS
        $threadObj = new Thread;
        $threadObj->heading = 'Comments';
        $threadObj->user_id = $userId;
        $threadObj->save();
        // The id of the new object will be used in the next insert        
        $threadId = $threadObj->id;

        // Create new test site
        $siteObj = new Site;
        $siteObj->thread_id = $threadId;
        $siteObj->hostUrl   = '//localhost:8000';
        $siteObj->save();

        // Create new test messages
        for ($i = 0; $i < 10; $i++) {
            Message::create(array(
                'thread_id' => $threadId,
                'email'     => 'test' . $i . '@thebelin.com',
                'message'   => 'This is a test Message '. $i,
                'gravatar'  => md5('thebelin@gmail.com')
            ));

        }

    } 
}
