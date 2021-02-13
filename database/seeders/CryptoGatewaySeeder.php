<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'type' => 'BTC',
            'description' => 'Use BTC to buy',
            'icon' => 'fab fa-bitcoin',
            'address_req' => '1',
            'confirm_decimal' => 3,
            'val1' => 'wallet-address',
            'val2' => 'value',
            'val3' => 'value',
            'val4' => 'encrypted-wallet',
            'status' => '0',
        ]);
        DB::table('crypto_gateways')->insert([
            'payment_id' => 1,
            'name' => 'ETH Wallet',
            'symbol' => 'ETH',
            'type' => 'ETH',
            'description' => 'Use ETH to buy',
            'icon' => 'fab fa-ethereum',
            'address_req' => '1',
            'confirm_decimal' => 3,
            'val1' => 'wallet-address2',
            'val2' => 'gas',
            'val3' => 'fee',
            'val4' => 'encrypted-wallet',
            'status' => '0',
        ]);
        DB::table('crypto_gateways')->insert([
            'payment_id' => 1,
            'name' => 'Tether ERC20',
            'symbol' => 'USDT',
            'type' => 'USDT_ERC20',
            'description' => 'Use Tether to buy',
            'icon' => 'fas fa-dollar-sign',
            'address_req' => '1',
            'confirm_decimal' => 2,
            'val1' => '0xe9F2d67F8A75C5BC1C36473be765aBA6e1F32a0a',
            'val2' => 'gas',
            'val3' => 'fee',
            'val4' => Hash::make('0xe9F2d67F8A75C5BC1C36473be765aBA6e1F32a0a'),
            'status' => '1',
        ]);
    }
}
