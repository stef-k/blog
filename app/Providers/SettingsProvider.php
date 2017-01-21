<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Settings;

class SettingsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = Settings::firstOrCreate(['settings_ver' => '1']);

        View::share('settings', $settings);
        View::share('author', env('USERNAME'));
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
