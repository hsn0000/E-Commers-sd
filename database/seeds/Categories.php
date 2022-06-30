<?php

use Illuminate\Database\Seeder;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('categories')->insert([
            [
                'parent_id' => 0,
                'name' => 'T-Shirts',
                'description' => 'T-Shirts Category',
                'url' => 't-shirts',
                'meta_title' => 'T-Shirts',
                'meta_description' => 'T-Shirts Category',
                'meta_keywords' => 'T-Shirts Category',
                'status' => 1,
            ],
            [
                'parent_id' => 1,
                'name' => 'Casual T-Shirts',
                'description' => 'Casual T-Shirts',
                'url' => 'casual-t-shirts',
                'meta_title' => 'casual-t-shirts',
                'meta_description' => 'casual-t-shirts',
                'meta_keywords' => 'casual-t-shirts',
                'status' => 1,
            ],
            [
                'parent_id' => 0,
                'name' => 'Trendy',
                'description' => 'Trendy',
                'url' => 'trendy',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 1,
            ],
            [
                'parent_id' => 3,
                'name' => 'Women s robe',
                'description' => 'women s robe religion',
                'url' => 'womens_robe',
                'meta_title' => 'women s robe',
                'meta_description' => 'women s robe religion',
                'meta_keywords' => 'women s robe e-commerce web',
                'status' => 1,
            ]
        ]);
    }
}
