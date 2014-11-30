<?php
 
class MessagesTableSeeder extends Seeder {
 
    public function run()
    {

        // Delete all the existing users
        DB::table('users')->delete();
        // Create the new test user
        $userObj = new User;
        $userObj->create(array(
            'email'    => 'test@thebelin.com',
            'password' => 'test_password'
        ));
        // The id of the new object will be used in the next insert
        $userId = $userObj->id;

        // THREADS
        DB::table('threads')->delete();
        $threadObj = new Thread;
        $threadObj->create(array(
            'heading' => 'Comments',
            'user_id' => $userId
        ));
        $threadId = $threadObj->id;

        // Delete all the existing sites
        DB::table('sites')->delete();
        // Create new test sites
        $siteObj = new Site;
        $siteObj->create(array(
            'thread_id' => $thread_id,
            'hostUrl'   => '//localhost:8000'
        ));
        $siteId = $siteObj->id;

        // Delete all the existing messages
        DB::table('messages')->delete();
        // Create new test messages
        for ($i = 0; $i < 10; $i++) {
            Message::create(array(
                'site_id'  => $siteId,
                'email'    => 'test' . $i . '@thebelin.com',
                'message'  => 'This is a test Message '. $i,
                'gravatar' => md5('thebelin@gmail.com')
            ));

        }



    }
 
}