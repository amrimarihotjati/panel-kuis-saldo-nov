<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Withdrawal;

class WithdrawalSeeder extends Seeder
{
    public function run()
    {
        Withdrawal::factory()->count(690)->create();
    }
}
