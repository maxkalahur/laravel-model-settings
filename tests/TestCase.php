<?php

namespace MaxKalahur\LaravelModelSettings\Tests;

use MaxKalahur\LaravelModelSettings\CustomSettingServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

use Illuminate\Foundation\Testing\RefreshDatabase;
use MaxKalahur\LaravelModelSettings\Tests\Models\DummyUser;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Schema::create('test_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamps();
        });
        
        DummyUser::create([
            'name' => 'Test',
            'email' => 'test@test.com',
        ]);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            CustomSettingServiceProvider::class,
        ];
    }
}
