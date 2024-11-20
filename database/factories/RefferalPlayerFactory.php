<?php

namespace Database\Factories;

use App\Models\RefferalPlayer;
use Illuminate\Database\Eloquent\Factories\Factory;


class RefferalPlayerFactory extends Factory
{
    public function definition()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return [
            'refferaled_registered_player' => $this->faker->numberBetween(11, 20),
            'refferaled_from_player' => $this->faker->numberBetween(1, 10),
            'refferaled_coins_added_to_player' => 20,
            'player_pkg' => 'com.kuis.saldo'
        ];
    }
}
