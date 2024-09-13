<?php

namespace Szhorvath\LaravelCloudflareStream;

use Psr\Http\Client\ClientInterface;
use Szhorvath\CloudflareStream\Concerns\StreamSigner;
use Szhorvath\CloudflareStream\DataObjects\ApiResponse;
use Szhorvath\CloudflareStream\StreamSdk;

class CloudflareStream
{
    public function __construct(
        protected StreamSdk $sdk,
        protected StreamSigner $signer,
        protected string $accountId,
    ) {}

    public function sdk(): StreamSdk
    {
        return $this->sdk;
    }

    public function client(): ClientInterface
    {
        return $this->sdk->client();
    }

    public function verifyToken(): ApiResponse
    {
        return $this->sdk->token()->verify();
    }

    public function createToken(string $videoId): string
    {
        return $this->signer->tokenFor($videoId);
    }
}
