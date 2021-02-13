<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReferenceLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  adding reference levels
        DB::table('reference_levels')->insert([
            'name' => 'Level 1',
            'level' => 1,
            'min_balance' => 0,
            'max_earnings' => 1000,
            'rate' => 10,
        ]);
        DB::table('reference_levels')->insert([
            'name' => 'Level 2',
            'level' => 2,
            'min_balance' => 100,
            'max_earnings' => 1000,
            'rate' => 8,
        ]);
        DB::table('reference_levels')->insert([
            'name' => 'Level 3',
            'level' => 3,
            'min_balance' => 200,
            'max_earnings' => 500,
            'rate' => 5,
        ]);
        DB::table('reference_levels')->insert([
            'name' => 'Level 4',
            'level' => 4,
            'min_balance' => 300,
            'max_earnings' => 500,
            'rate' => 3,
        ]);
        DB::table('reference_levels')->insert([
            'name' => 'Level 5',
            'level' => 5,
            'min_balance' => 400,
            'max_earnings' => 250,
            'rate' => 1,
        ]);
    }
}
