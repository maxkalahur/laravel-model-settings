<?php

namespace MaxKalahur\LaravelModelSettings\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use MaxKalahur\LaravelModelSettings\CustomSettingServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use DatabaseTransactions;

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            CustomSettingServiceProvider::class,
        ];
    }
}
