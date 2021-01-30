<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //adding payment methods
        DB::table('payment_methods')->insert([
            'name' => 'Crypto Payments',
            'description' => 'Take payments with crypto wallets by manual',
            'type' => 'cryptopay',
            'status' => '1',
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'Bank Transfer',
            'description' => 'Take payments with bank transfer',
            'type' => 'banktransfer',
            'status' => '0',
        ]);
        DB::table('payment_methods')->insert([
            'name' => 'PayPal',
            'description' => 'Take payments with PayPal',
            'type' => 'paypal',
            'status' => '0',
        ]);
    }
}
