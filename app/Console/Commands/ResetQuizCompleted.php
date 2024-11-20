<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\PanelSetting;
use App\Models\QuizCompleted;

class ResetQuizCompleted extends Command
{
    protected $signature = 'quizcompleted:reset';
    protected $description = 'Resets all QuizCompleted records if enabled in settings';

    public function handle()
    {
        $resetQuizEnabled = PanelSetting::where('key', 'quiz_completed_reset')->where('status', 1)->first();

        if ($resetQuizEnabled) {
            QuizCompleted::query()->delete();
            Log::info('All QuizCompleted records have been reset.');
            $this->info('All QuizCompleted records have been reset.');
        } else {
            Log::info('QuizCompleted reset is disabled.');
            $this->info('QuizCompleted reset is disabled.');
        }

        return 0;
    }
}
