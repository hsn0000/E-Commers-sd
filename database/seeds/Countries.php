<?php

use Illuminate\Database\Seeder;

class Countries extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('countries')->insert([
            [
                'country_code' => 'IND',
                'country_name' => 'Indonesia',
                'created_at' => now()
            ],
            [
                'country_code' => 'GER',
                'country_name' => 'Germany',
                'created_at' => now()
            ],
        ]);
    }
}
