<?php

namespace Database\Factories;

use App\Models\CryptoPay;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CryptoPayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CryptoPay::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $amount = $this->faker->numberBetween(10000,100000);
        $status = ['pending', 'rejected', 'confirmed', 'canceled'];
        $current_value = rand(5000,30000);
        return [
            'user_id' => 1,
            'stage_id' => rand(1,3),
            'payment_id' => 1,
            'gateway_id' => 2,
            'external_wallet_id' => 1,
            'amount' => $amount,
            'price' => 0.06,
            'total' => $amount*0.06,
            'payable' => ($amount*0.06)/$current_value,
            'current_value' => $current_value,
            'txhash' => Str::random(20),
            'user_note' => $this->faker->sentence(),
            'admin_note' => $this->faker->sentence(),
            'status' => $status[rand(0,3)],
        ];
    }
}
