<?php

declare(strict_types=1);

namespace Szhorvath\LaravelCloudflareStream;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Szhorvath\CloudflareStream\Concerns\StreamSigner;
use Szhorvath\CloudflareStream\StreamSdk;
use Szhorvath\LaravelCloudflareStream\Commands\SubscribeToWebhookNotificationsCommand;
use Szhorvath\LaravelCloudflareStream\Commands\VerifyCloudflareStreamTokenCommand;

class CloudflareStreamServiceProvider extends PackageServiceProvider
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
            ->hasMigration('create_webhook_calls_table')
            ->hasCommand(VerifyCloudflareStreamTokenCommand::class)
            ->hasCommand(SubscribeToWebhookNotificationsCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->scoped(StreamSdk::class, function () {
            return new StreamSdk(
                token: config('cloudflare-stream.api_token'),
                baseUrl: config('cloudflare-stream.base_url'),
            );
        });

        $this->app->scoped(StreamSigner::class, function () {
            return new StreamSigner(
                pem: config('cloudflare-stream.pem'),
                keyId: config('cloudflare-stream.key_id'),
            );
        });

        $this->app->bind('cloudflare-stream', function ($app) {
            return new CloudflareStream(
                sdk: $app->make(StreamSdk::class),
                signer: $app->make(StreamSigner::class),
            );
        });

        if (config('cloudflare-stream.webhook.enabled', true)) {
            $this->mergeWebhookClientConfig();
        }
    }

    /**
     *  merge webhook-client config with cloudflare-stream webhook config
     * and remove default config when it is not filled by the developer
     *
     * @throws BindingResolutionException
     */
    protected function mergeWebhookClientConfig(): void
    {
        $webhookConfigs = (new Collection(config('webhook-client.configs', [])))
            ->reject(fn (array $config) => $config['name'] === 'default' && ! $config['process_webhook_job'])
            ->push(config('cloudflare-stream.webhook', []));

        config(['webhook-client.configs' => $webhookConfigs->toArray()]);
    }
}
