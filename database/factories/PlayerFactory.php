<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomString = '';
        for ($i = 0; $i < 16; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        $player_pkg = [
            'com.kuis.ovo',
            'com.kuis.saldo'
        ];
        
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'score' => $this->faker->numberBetween(0, 0),
            'points' => $this->faker->numberBetween(0, 0),
            'points_collected' => $this->faker->numberBetween(0, 0) + 0,
            'referral_code' => $randomString,
            'status' => $this->faker->numberBetween(0, 2),
            'password' => bcrypt('password'), 
            'player_pkg' => $this->faker->randomElement($player_pkg),
            'real_player' => 1,
        ];
    }
}
