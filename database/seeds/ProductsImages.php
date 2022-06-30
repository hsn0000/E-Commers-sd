<?php

use Illuminate\Database\Seeder;

class ProductsImages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products_images')->insert([
            [
                'product_id' => 3,
                'image' => '90929.jpg',
                'created_at' => now(),
            ],
            [
                'product_id' => 3,
                'image' => '53505.jpg',
                'created_at' => now(),
            ],
            [
                'product_id' => 3,
                'image' => '62346.jpg',
                'created_at' => now(),
            ],
            [
                'product_id' => 1,
                'image' => '59511.jpg',
                'created_at' => now(),
            ],
            [
                'product_id' => 1,
                'image' => '42641.jpg',
                'created_at' => now(),
            ],
            [
                'product_id' => 1,
                'image' => '69088.jpg',
                'created_at' => now(),
            ],
        ]);
    }
}
