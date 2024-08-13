<?php

namespace Szhorvath\LaravelCloudflareStream;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Szhorvath\LaravelCloudflareStream\Commands\LaravelCloudflareStreamCommand;

class LaravelCloudflareStreamServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-cloudflare-stream')
            ->hasConfigFile()
            // ->hasViews()
            ->hasMigration('create_webhook_calls_table');
        // ->hasCommand(LaravelCloudflareStreamCommand::class);
    }
}
