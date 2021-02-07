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
        //adding wallet for admin

            DB::table('wallets')->insert([
                'user_id' => 1,
                'type' => 'FTX',
                'address' => 'FTX000001',
                'balance' => 0,
            ]);
    }
}
