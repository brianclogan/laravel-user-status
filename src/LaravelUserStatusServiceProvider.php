<?php

namespace BrianLogan\LaravelUserStatus;

use BrianLogan\LaravelUserStatus\Commands\LaravelUserStatusCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelUserStatusServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-user-status')
            ->hasConfigFile()
            ->hasMigration('create_laravel-user-status_table')
            ->hasCommand(LaravelUserStatusCommand::class);
    }
}
