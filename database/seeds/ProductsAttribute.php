<?php

use Illuminate\Database\Seeder;

class ProductsAttribute extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products_attributes')->insert([
            [
                'product_id' => 1,
                'sku' => 'FTS001-S',
                'size' => 'small',
                'price' => 230000,
                'stock' => 40,
                'created_at' => now(),
            ],
            [
                'product_id' => 1,
                'sku' => 'FTS001-M',
                'size' => 'Medium',
                'price' => 240000,
                'stock' => 44,
                'created_at' => now(),
            ],
            [
                'product_id' => 1,
                'sku' => 'FTS001-L',
                'size' => 'Large',
                'price' => 250000,
                'stock' => 45,
                'created_at' => now(),
            ],
            [
                'product_id' => 1,
                'sku' => 'FTS001-XL',
                'size' => 'X Large',
                'price' => 260000,
                'stock' => 20,
                'created_at' => now(),
            ],
            [
                'product_id' => 1,
                'sku' => 'FTS001-XXL',
                'size' => 'XL Large',
                'price' => 270000,
                'stock' => 23,
                'created_at' => now(),
            ],
        ]);
    }
}
