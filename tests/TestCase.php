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
            'password' => '123',
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            CustomSettingServiceProvider::class,
        ];
    }
}
