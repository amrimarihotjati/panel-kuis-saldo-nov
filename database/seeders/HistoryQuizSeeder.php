<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoryQuiz;

class HistoryQuizSeeder extends Seeder
{
    public function run()
    {
        HistoryQuiz::factory()->count(820)->create();
    }
}
