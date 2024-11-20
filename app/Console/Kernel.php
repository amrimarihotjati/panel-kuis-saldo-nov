<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\ResetQuizCompleted::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        if (\App\Models\PanelSetting::where('key', 'quiz_completed_reset')->where('status', 1)->exists()) {
            \Log::info('Scheduling quizcompleted:reset command daily.');
            $schedule->command('quizcompleted:reset')->daily()->timezone('Asia/Jakarta');
        }
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}

