<?php

use Illuminate\Database\Seeder;

class Currency extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('currencies')->insert([
            [
                'currency_name' => 'Indonesian Rupiah',
                'currency_simbol' => 'Rp',
                'currency_code' => 'IDR',
                'exchange_rate' => 1,
                'status' => 1,
            ],
            [
                'currency_name' => 'Cambodian riel',
                'currency_simbol' => '៛',
                'currency_code' => 'KHR',
                'exchange_rate' => '4041.88',
                'status' => 1,
            ],
            [
                'currency_name' => 'USD Dollar',
                'currency_simbol' => '$',
                'currency_code' => 'USD',
                'exchange_rate' => '14386.63',
                'status' => 1,
            ],
            [
                'currency_name' => 'Euro',
                'currency_simbol' => '€',
                'currency_code' => 'EUR',
                'exchange_rate' => '15386.63',
                'status' => 1,
            ],
        ]);
    }
}
