<?php

namespace MaxKalahur\LaravelModelSettings;

use Illuminate\Support\ServiceProvider;

class CustomSettingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
