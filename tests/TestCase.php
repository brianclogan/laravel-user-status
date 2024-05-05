<?php

namespace BrianLogan\LaravelUserStatus\Tests;

use BrianLogan\LaravelUserStatus\LaravelUserStatusServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;
    use WithWorkbench;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'BrianLogan\\LaravelUserStatus\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelUserStatusServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_user_status_table.php.stub';
        $migration->up();
//
//        foreach (glob(__DIR__.'/../workbench/database/migrations/*.php') as $migration) {
//            $migration = include $migration;
//            $migration->up();
//        }
    }
}
