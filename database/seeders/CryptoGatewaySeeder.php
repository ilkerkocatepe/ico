<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CryptoGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding first crypto gateways
        DB::table('crypto_gateways')->insert([
            'payment_id' => 1,
            'name' => 'BTC Wallet',
            'symbol' => 'BTC',
            'description' => 'Use BTC to buy',
            'icon' => 'fab fa-bitcoin',
            'address_req' => '1',
            'confirm_decimal' => 3,
            'val1' => 'wallet-address',
            'val2' => 'value',
            'val3' => 'value',
            'val4' => 'encrypted-wallet',
            'status' => '1',
        ]);
        DB::table('crypto_gateways')->insert([
            'payment_id' => 1,
            'name' => 'ETH Wallet',
            'symbol' => 'ETH',
            'description' => 'Use ETH to buy',
            'icon' => 'fab fa-ethereum',
            'address_req' => '1',
            'confirm_decimal' => 3,
            'val1' => 'wallet-address2',
            'val2' => 'gas',
            'val3' => 'fee',
            'val4' => 'encrypted-wallet',
            'status' => '1',
        ]);
    }
}
