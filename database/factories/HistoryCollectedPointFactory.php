<?php

namespace Database\Factories;

use App\Models\HistoryCollectedPoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryCollectedPointFactory extends Factory
{
    public function definition()
    {

        $point_collected_from = [
            'app-quiz:com.kuis.saldo',
        ];

        $description = [
            'playing quiz',
            'watch rewards ads get point',
            'Added commision withdraw point from Refferaled'
        ];

        return [
            'player_id' => $this->faker->numberBetween(1, 20),
            'point_collected_from' => $this->faker->randomElement($point_collected_from),
            'point_collected_value' => $this->faker->numberBetween(0, 80),
            'description' => $this->faker->randomElement($description),
            'player_pkg' => 'com.kuis.saldo',
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
