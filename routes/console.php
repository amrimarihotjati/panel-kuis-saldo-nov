<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();

Artisan::command('quizcompleted:reset', function () {
    $this->call('App\Console\Commands\ResetQuizCompleted');
})->daily();

