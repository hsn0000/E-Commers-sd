<?php

use Illuminate\Database\Seeder;

class Banners extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('banners')->insert([
            [
                'image' => '10844.png',
                'title' => 'Commerce Solution',
                'link' => 'banners_solution',
                'status' => 1,
                'created_at' => now()
            ],
            [
                'image' => '83855.png',
                'title' => 'E-commerce Website',
                'link' => 'e_commerce_website',
                'status' => 1,
                'created_at' => now()
            ]
        ]);
    }
}
