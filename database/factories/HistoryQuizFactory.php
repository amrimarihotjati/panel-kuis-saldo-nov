<?php

namespace Database\Factories;

use App\Models\HistoryQuiz;
use Illuminate\Database\Eloquent\Factories\Factory;


class HistoryQuizFactory extends Factory
{
     public function definition()
    {

        $category_id = [
            '5ce2dd12-36ba-4ced-a615-628a7d85f6ad',
            'b95633a2-25eb-467c-9998-ae69ef6def8e',
            '7ee4e186-252d-41e2-a4dd-8877d69ee253',
        ];

        $category_level = [
            0,1,2,3
        ];

        return [
            'player_id' => $this->faker->numberBetween(1, 20),
            'score' => $this->faker->numberBetween(8, 50),
            'points' => $this->faker->numberBetween(8, 50),
            'ads_watched_inters' => $this->faker->numberBetween(2, 20),
            'ads_watched_rewards' => $this->faker->numberBetween(0, 2),
            'category_id' => $this->faker->randomElement($category_id),
            'category_level' => $this->faker->randomElement($category_level),
            'total_quiz_points' => $this->faker->numberBetween(20, 50),
            'completed_option' => $this->faker->numberBetween(0, 1),
            'with_double_option' => $this->faker->numberBetween(0, 1),
            'player_pkg' => 'com.kuis.saldo',
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now')
        ];
    }
}
