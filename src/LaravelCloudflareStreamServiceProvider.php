<?php

namespace Szhorvath\LaravelCloudflareStream;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Szhorvath\CloudflareStream\StreamSdk;
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
            ->hasConfigFile(['cloudflare-stream', 'webhook-client'])
            ->hasRoute('stream')
            // ->hasViews()
            ->hasMigration('create_webhook_calls_table');
        // ->hasCommand(LaravelCloudflareStreamCommand::class);
    }

    public function packageRegistered()
    {
        $this->app->bind('cf-stream', function () {
            return new StreamSdk(
                token: config('cloudflare-stream.api_token'),
                baseUrl: config('cloudflare-stream.base_url'),
            );
        });
    }
}
