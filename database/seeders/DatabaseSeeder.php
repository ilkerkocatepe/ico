<?php

namespace Database\Seeders;

use App\Models\CryptoPay;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            SocialSeeder::class,
            StageSeeder::class,
            PriceSeeder::class,
            PaymentMethodSeeder::class,
            CryptoGatewaySeeder::class,
            ExternalWalletSeeder::class,
            ReferenceLevelSeeder::class,
        ]);
        //CryptoPay::factory(50)->create();
        //User::factory(30)->create();
        $this->call([
            WalletSeeder::class,
        ]);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Accountant']);
        Role::create(['name' => 'Editor']);
    }
}
