<?php

namespace Homeful\Common;

use Homeful\Common\Commands\CommonCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CommonServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('common')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_common_table')
            ->hasCommand(CommonCommand::class);
    }
}
