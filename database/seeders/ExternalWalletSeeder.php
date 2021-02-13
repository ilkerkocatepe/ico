<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExternalWalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding wallet for admin
        DB::table('external_wallets')->insert([
            'user_id' => 1,
            'name' => 'My Tether Wallet',
            'type' => 'USDT_ERC20',
            'description' => 'ERC20 Tether Wallet',
            'address' => Str::random('15'),
            'status' => '1',
        ]);
    }
}
