<?php

use Illuminate\Database\Seeder;
// use DB;

class UserGroup extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_group')->insert([
            [            
                'gname' => 'Generator',
                'roles' => json_encode(['*'])
            ],
            [
                'gname' => 'Superior',
                'roles' => '{
                    "view":"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25",
                    "create":"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25",
                    "alter":"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25",
                    "drop":"1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25"
                }'
            ]
        ]);

        \DB::table('user_group')->where(['guid'=>1])->update(['guid' => 0]);
        \DB::table('user_group')->where(['guid'=>2])->update(['guid' => 1]);
    }
}
