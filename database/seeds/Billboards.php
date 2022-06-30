<?php

use Illuminate\Database\Seeder;

class Billboards extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('billboards')->insert([
            [
                'image' => '67216.jpg',
                'title' => 'Shipping Education',
                'link' => 'shipping_education',
                'status' => 1,
                'created_at' => now()
            ],
            [
                'image' => '36515.jpg',
                'title' => 'Winning Shipping',
                'link' => 'winning_shipping',
                'status' => 1,
                'created_at' => now()
            ],
            [
                'image' => '32248.jpg',
                'title' => 'Dropshipping Home',
                'link' => 'dropshipping_home',
                'status' => 1,
                'created_at' => now()
            ]
        ]);
    }
}
