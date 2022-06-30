<?php

use Illuminate\Database\Seeder;
// use DB;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $insert = array(
          'guid' => 1,
          'avatar' => null,
          'name' => 'superior',
          'email' => 'superior@yopmail.com',
          'admin' => 1,
          'status' => 1,
          'password' => md5('asdasd')
       ); 

       \DB::table('users')->insert($insert);
    }
}
