<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserGroup::class,
            Users::class,
            Modules::class,
            Banners::class,
            Billboards::class,
            NewsInformation::class,
            Categories::class,
            Products::class,
            ProductsAttribute::class,
            ProductsImages::class,
            Currency::class,
            Countries::class,
            Pincodes::class,
        ]);
    }
}
