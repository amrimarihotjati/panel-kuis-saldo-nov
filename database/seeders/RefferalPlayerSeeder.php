<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefferalPlayer;

class RefferalPlayerSeeder extends Seeder
{
    public function run()
    {
        RefferalPlayer::factory()->count(150)->create();
    }
}
