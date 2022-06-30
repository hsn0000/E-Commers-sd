<?php

use Illuminate\Database\Seeder;

class NewsInformation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('news_info')->insert([
            [
                'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptate esse itaque sunt nisi voluptatem suscipit sapiente odio aperiam cumque necessitatibus. Maxime optio animi, nihil id ea quia quidem molestias ad.',
                'url' => 'test-url',
                'status' => 1,
                'created_at' => now()
            ],
            [
                'description' => 'Selamat Datang Di E-commerce HSN',
                'url' => 'welcome-commerce',
                'status' => 1,
                'created_at' => now()
            ]
        ]);
    }
}
