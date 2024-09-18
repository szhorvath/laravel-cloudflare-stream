<?php

namespace Szhorvath\LaravelCloudflareStream;

use Psr\Http\Client\ClientInterface;
use Szhorvath\CloudflareStream\Concerns\StreamSigner;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\DataObjects\Token\Verify;
use Szhorvath\CloudflareStream\DataObjects\Webhook\Webhook;
use Szhorvath\CloudflareStream\StreamSdk;

class CloudflareStream
{
    /**
     * Create a new CloudflareStream instance.
     *
     * @return void
     */
    public function __construct(
        protected StreamSdk $sdk,
        protected StreamSigner $signer,
    ) {}

    public function sdk(): StreamSdk
    {
        return $this->sdk;
    }

    public function signer(): StreamSigner
    {
        return $this->signer;
    }

    public function client(): ClientInterface
    {
        return $this->sdk->client();
    }

    /**
     * Verify the Cloudflare Stream token.
     *
     * @return ApiResponse<Verify>
     */
    public function verifyToken(): ApiResponse
    {
        return $this->sdk->token()->verify();
    }

    public function createToken(string $videoId): string
    {
        return $this->signer->tokenFor($videoId);
    }

    /**
     * Subscribe to Cloudflare Stream webhooks.
     *
     * @return ApiResponse<Webhook>
     */
    public function subscribeToWebhooks(?string $url = null): ApiResponse
    {
        return $this->sdk->webhook()->create(
            accountId: config('cloudflare-stream.account_id'),
            data: ['notificationUrl' => $url ?: url(config('cloudflare-stream.webhook.url'))]
        );
    }
}
