<?php

namespace Database\Factories;

use App\Models\Withdrawal;

use Illuminate\Database\Eloquent\Factories\Factory;


class WithdrawalFactory extends Factory
{

    public function definition()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        $paymentMethods = [
            '577f9647-ec22-435e-8c0a-6f11f5b93012',
            '62d3b0bc-a56e-4225-97df-91798724e2ec',
            '90428716-d3ae-4e44-8faa-98215566108e',
            'dee2b2f5-8c25-4f40-a330-bf78c2ccb664',
        ];

        $paymentAccounts = [];
        for ($i = 0; $i < 500; $i++) {
            $paymentAccounts[] = '08' . str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT);
        }
        
        return [
            'player_id' => $this->faker->numberBetween(1, 20),
            'amount' => $this->faker->numberBetween(13000, 30000),
            'points' => $this->faker->numberBetween(13000, 30000),
            'status' => $this->faker->numberBetween(0, 2),
            'payment_method' =>  $this->faker->randomElement($paymentMethods),
            'payment_account' => $this->faker->randomElement($paymentAccounts),
            'player_pkg' => 'com.kuis.saldo',
            'created_at' => $this->faker->dateTimeBetween('-3 year', 'now')
        ];
    }
}
