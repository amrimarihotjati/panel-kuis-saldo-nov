<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Dedoc\Scramble\Scramble;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
         Scramble::ignoreDefaultRoutes();
         $loader = \Illuminate\Foundation\AliasLoader::getInstance();
         $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    public function boot(): void
    {
        Scramble::registerApi('v2', [
            'api_path' => 'api/v2',
        ]);

        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set('Asia/Jakarta');
    }
}
