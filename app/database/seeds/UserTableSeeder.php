<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
        	'username' => 'birboluiki',
        	'password' => Hash::make('domates2016'),
        	'status' => 1,
        	'group' => 1,
        	'email' => 'birboluikidestek@gmail.com')
        );
    }

}