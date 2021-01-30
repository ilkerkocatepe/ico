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
        for ($i=1; $i<32; $i++)
        {
            DB::table('wallets')->insert([
                'user_id' => $i,
                'type' => 'FTX',
                'address' => 'FTX00000'.$i,
                'balance' => 0,
            ]);
        }
    }
}
