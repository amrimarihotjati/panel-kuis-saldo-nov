<?php

namespace Database\Factories;

use App\Models\HistoryQuiz;
use Illuminate\Database\Eloquent\Factories\Factory;


class HistoryQuizFactory extends Factory
{
     public function definition()
    {

        $category_id = [
            'acc856d1-cbdc-4e4e-a6d0-3104ce902bda',
        ];

        $category_level = [
            0
        ];

        return [
            'player_id' => $this->faker->numberBetween(1, 5),
            'score' => 10,
            'points' => 10,
            'ads_watched_inters' => $this->faker->numberBetween(2, 20),
            'ads_watched_rewards' => $this->faker->numberBetween(0, 2),
            'category_id' => $this->faker->randomElement($category_id),
            'category_level' => $this->faker->randomElement($category_level),
            'total_quiz_points' => $this->faker->numberBetween(10, 50),
            'completed_option' => $this->faker->numberBetween(0, 1),
            'with_double_option' => $this->faker->numberBetween(0, 1),
            'player_pkg' => 'com.kuis.saldo',
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
