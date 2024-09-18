<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Szhorvath\LaravelCloudflareStream\Facades\CloudflareStream;

use function Pest\Laravel\artisan;

it('should subscribe to webhook notifications', function () {
    CloudflareStream::fake([
        [
            'result' => [
                'notification_url' => 'https://example.com/webhook',
                'notificationUrl' => 'https://example.com/webhook',
                'modified' => '2024-08-14T09:13:00.112845Z',
                'secret' => 'e853f3bd4563a66c86979cd584f08eb3c72ddd75',
            ],
            'success' => true,
            'errors' => [],
            'messages' => [],
        ],
    ]);

    artisan('cloudflare:subscribe-to-webhook-notifications')
        ->expectsOutput('Subscribed to Cloudflare Stream webhook notifications. URL: https://example.com/webhook')
        ->expectsOutput('Signing secret: e853f3bd4563a66c86979cd584f08eb3c72ddd75')
        ->assertSuccessful();
});

it('should notify when subscribing not successful', function () {
    CloudflareStream::fake([
        [
            'result' => null,
            'success' => false,
            'errors' => [
                ['code' => 10000, 'message' => 'Invalid API token'],
            ],
            'messages' => [],
        ],
    ]);

    artisan('cloudflare:subscribe-to-webhook-notifications')
        ->expectsOutput('Failed to subscribe to Cloudflare Stream webhook notifications: Invalid API token')
        ->assertFailed();
});

it('should be able to change url with command parameter', function(){
    CloudflareStream::fake([
        [
            'result' => [
                'notification_url' => 'https://example.com/webhook2',
                'notificationUrl' => 'https://example.com/webhook2',
                'modified' => '2024-08-14T09:13:00.112845Z',
                'secret' => 'e853f3bd4563a66c86979cd584f08eb3c72ddd75',
            ],
            'success' => true,
            'errors' => [],
            'messages' => [],
        ],
    ]);

    artisan('cloudflare:subscribe-to-webhook-notifications', ['--url' => 'https://example.com/webhook2'])
        ->expectsOutput('Subscribed to Cloudflare Stream webhook notifications. URL: https://example.com/webhook2')
        ->expectsOutput('Signing secret: e853f3bd4563a66c86979cd584f08eb3c72ddd75')
        ->assertSuccessful();
});
