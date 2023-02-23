<?php

namespace MaxKalahur\LaravelModelSettings\Tests;

use MaxKalahur\LaravelModelSettings\CustomSettingServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MaxKalahur\LaravelModelSettings\Tests\Models\DummyUser;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        DummyUser::create([
            'name' => 'Test',
            'email' => 'test@test.com',
        ]);
    }

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
