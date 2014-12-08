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
        for ($i = 0; $i < 1000; $i++) {
            Message::create(array(
                'thread_id' => $threadId,
                'email'     => 'test' . $i . '@thebelin.com',
                'message'   => $this->makeLorems() . '(' . $i . ')',
                'gravatar'  => md5('thebelin@gmail.com')
            ));
        }
    }
    private function makeLorems ()
    {
        $ret = '';
        for ($i = 0, $max = rand(1, 12); $i < $max; $i++) {
            $ret .= $this->makeLorem() . ' ';
        }
        return $ret;
    } 
    private function makeLorem ()
    {
        switch (rand(0, 4)) {
            case 0:
            case 1:
            $ret = 'You ';
            $end = '.';
            break;
            case 2:
            $ret = 'Does ';
            $end = '?';
            break;
            case 3:
            $ret = 'If ';
            $end = '.';
            break;
            case 4:
            $ret = 'Because ';
            $end = '.';
            break;
        }
        $ipsum = explode(' ', 'world is calling to via electromagnetic resonance can hear it how should ' .
            'navigate this unrestricted totality can be difficult to know where to begin you and I are beings ' .
            'of solar system we dream heal are reborn quantum cycle is full of ultrasonic energy if have never ' .
            'experienced this spark devoid of self it can be difficult to heal have you found your mission lifeform ' .
            'look within and fulfill yourself prophet totality may inspire this harmonizing of spacetime must take ' .
            'a stand against materialism dogma is born in gap where rejuvenation has been excluded');
        $maxipsum = count($ipsum) - 1;
        for ($i = 0, $max = rand(3, 20); $i < $max; $i++) {
            $ret .= ' ' . $ipsum[rand(0, $maxipsum)];
        }
        $ret .= $end;
        return $ret;
    } 
}
