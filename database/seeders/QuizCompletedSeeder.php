<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizCompleted;

class QuizCompletedSeeder extends Seeder
{
    public function run()
    {
        QuizCompleted::factory()->count(230)->create();
    }
}
