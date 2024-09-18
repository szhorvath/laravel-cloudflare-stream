<?php

namespace Szhorvath\LaravelCloudflareStream\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Szhorvath\LaravelCloudflareStream\Facades\CloudflareStream;
use Throwable;

/**
 * @see https://developers.cloudflare.com/stream/manage-video-library/using-webhooks/#subscribe-to-webhook-notifications
 */
#[AsCommand(name: 'cloudflare:subscribe-to-webhook-notifications')]
class SubscribeToWebhookNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'cloudflare:subscribe-to-webhook-notifications
                        {--url= : The URL to receive Cloudflare Stream webhook notifications}';

    /**
     * The console command description.
     *
     * @var string|null
     */
    public $description = 'Subscribe to Cloudflare Stream webhook notifications';

    public function handle(): int
    {
        $url = is_string($this->option('url')) ? $this->option('url') : null;

        try {
            $response = CloudflareStream::subscribeToWebhooks($url);

            if ($response->failed()) {
                $this->error("Failed to subscribe to Cloudflare Stream webhook notifications: {$response->error()}");

                return self::FAILURE;
            }

            $this->info('Subscribed to Cloudflare Stream webhook notifications. URL: '.$response->result?->notification_url);
            $this->info('Signing secret: '.$response->result?->secret);

            return self::SUCCESS;
        } catch (Throwable $th) {
            $this->error("Failed to verify Cloudflare Stream API token: {$th->getMessage()}");

            return self::FAILURE;
        }
    }
}
