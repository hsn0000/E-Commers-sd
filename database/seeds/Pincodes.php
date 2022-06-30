<?php

use Illuminate\Database\Seeder;

class Pincodes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert = array(
            [
                'pincode' => '15330',
                'village_office' => 'ALLOGIO',
                'sub_district' => 'PADEMANGAN',
                'city' => 'KAB TANGERANG',
                'province' => 'BANTEN',
                'state' => 'INDONESIA',
                'created_at' => now(),
            ],
            [
                'pincode' => '16421',
                'village_office' => 'ALLABASTA',
                'sub_district' => 'PAKARANGAN',
                'city' => 'GOD ENEL',
                'province' => 'MARIEJOICE',
                'state' => 'READLINE',
                'created_at' => now(),
            ],
        );

        \DB::table('pincodes')->insert($insert);
        \DB::table('cod_pincodes')->insert($insert);
    }
}
