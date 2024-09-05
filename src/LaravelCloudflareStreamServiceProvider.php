<?php

declare(strict_types=1);

namespace Szhorvath\LaravelCloudflareStream;

use Illuminate\Support\Collection;
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
            ->hasConfigFile(['cloudflare-stream'])
            ->hasRoute('stream')
            // ->hasViews()
            ->hasMigration('create_webhook_calls_table');
        // ->hasCommand(LaravelCloudflareStreamCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->bind('cf-stream', function () {
            return new StreamSdk(
                token: config('cloudflare-stream.api_token'),
                baseUrl: config('cloudflare-stream.base_url'),
            );
        });

        // merge webhook-client config with cloudflare-stream webhook config
        // and remove default config when it is not filled by the developer
        $webhookConfigs = (new Collection(config('webhook-client.configs', [])))
            ->reject(fn (array $config) => $config['name'] === 'default' && ! $config['process_webhook_job'])
            ->push(config('cloudflare-stream.webhook', []));

        config(['webhook-client.configs' => $webhookConfigs->toArray()]);
    }
}
