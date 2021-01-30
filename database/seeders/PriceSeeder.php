<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding first prices
        DB::table('prices')->insert([
            'stage_id' => 1,
            'min_amount' => 100,
            'max_amount' => 5000,
            'price' => 0.05,
            'status' => '0',
        ]);
        DB::table('prices')->insert([
            'stage_id' => 1,
            'min_amount' => 5000,
            'max_amount' => 10000,
            'price' => 0.04,
            'status' => '0',
        ]);
    }
}
