<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding first stage
        DB::table('stages')->insert([
            'name' => 'Old Sale',
            'description' => 'Old Sale for ICO Project',
            'amount' => 1000000,
            'min_buy' => 100,
            'max_buy' => 10000,
            'price_type' => 'fixed',
            'fixed_price' => 0.06,
            'status' => 'canceled',
        ]);
        DB::table('stages')->insert([
            'name' => 'First Sale',
            'description' => 'First Sale for ICO Project',
            'amount' => 10000000,
            'min_buy' => 100,
            'max_buy' => 10000,
            'price_type' => 'fixed',
            'fixed_price' => 0.08,
            'status' => 'running',
        ]);
        DB::table('stages')->insert([
            'name' => 'Second Sale',
            'description' => 'Second Sale for ICO Project',
            'amount' => 20000000,
            'min_buy' => 100,
            'max_buy' => 10000,
            'price_type' => 'fixed',
            'fixed_price' => 0.10,
            'status' => 'pending',
        ]);
    }
}
