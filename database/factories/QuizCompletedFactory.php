<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class QuizCompletedFactory extends Factory
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
            'player_id' => $this->faker->numberBetween(1, 100),
            'category_id' => $this->faker->randomElement($category_id),
            'category_level' => $this->faker->randomElement($category_level),
            'is_use_completed' => $this->faker->numberBetween(0, 1),
            'player_pkg' => 'com.kuis.saldo'
        ];
    }
}
