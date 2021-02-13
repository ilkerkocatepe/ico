<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i<6; $i++)
        {
            DB::table('wallets')->insert([
                'user_id' => $i,
                'type' => env('TOKEN_SYMBOL'),
                'address' => env('TOKEN_SYMBOL').'x0'.Str::random(20),
                'balance' => 0,
                'created_at' => now(),
            ]);
        }
    }
}
