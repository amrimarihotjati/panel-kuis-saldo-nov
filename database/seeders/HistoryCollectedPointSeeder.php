<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoryCollectedPoint;

class HistoryCollectedPointSeeder extends Seeder
{
    public function run()
    {
        HistoryCollectedPoint::factory()->count(540)->create();
    }
}
