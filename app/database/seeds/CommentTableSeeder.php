<?php
 
class CommentTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('comments')->delete();
 
        Comments::create(array(
            'email' => 'test@test.com',
            'message' => 'This is a test Message');
        ));

        Comments::create(array(
            'email' => 'test2@test.com',
            'message' => 'This is another test Message');
        ));
 
    }
 
}