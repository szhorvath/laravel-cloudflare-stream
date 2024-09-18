<?php

namespace Szhorvath\LaravelCloudflareStream\Facades;

use GuzzleHttp\Psr7\Response as Psr7Response;
use Http\Mock\Client as MockClient;
use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\ResponseInterface;
use Szhorvath\CloudflareStream\ClientBuilder;
use Szhorvath\CloudflareStream\Concerns\StreamSigner;
use Szhorvath\CloudflareStream\StreamSdk;
use Szhorvath\LaravelCloudflareStream\CloudflareStream as CfStream;

/**
 * @see \Szhorvath\CloudflareStream\StreamSdk
 *
 * @method static \Szhorvath\CloudflareStream\DataObjects\ApiResponse<\Szhorvath\CloudflareStream\DataObjects\Token\Verify> verifyToken()
 * @method static \Szhorvath\CloudflareStream\DataObjects\ApiResponse<\Szhorvath\CloudflareStream\DataObjects\Webhook\Webhook> subscribeToWebhooks(?string $url = null)
 */
class CloudflareStream extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'cloudflare-stream';
    }

    /**
     * Register a stub callable that will intercept requests and be able to return stub responses.
     *
     * @param  \Closure|array<int, mixed>|null  $callback
     */
    public static function fake(\Closure|array|null $callback = null): void
    {
        $client = new MockClient;

        if (is_array($callback)) {
            foreach ($callback as $data) {
                $client->addResponse(static::response($data));
            }
        }

        $fakeSdk = new StreamSdk(
            token: 'fake-token',
            clientBuilder: new ClientBuilder(
                httpClient: $client,
            )
        );

        $fake = new CfStream(
            sdk: $fakeSdk,
            signer: new StreamSigner(
                pem: 'fake-pem',
                keyId: 'fake-key-id'
            )
        );

        static::swap($fake);
    }

    /**
     * Register a response sequence for the given URL pattern.
     *
     * @param  array<string, mixed>  $headers
     * @param  array<string, mixed>|string|null  $body
     */
    public static function response(array|string|null $body = null, int $status = 200, array $headers = []): ResponseInterface
    {
        if (is_array($body)) {
            $body = json_encode(
                value: $body,
                flags: JSON_THROW_ON_ERROR
            );

            $headers['Content-Type'] = 'application/json';
        }

        return new Psr7Response($status, $headers, $body);
    }
}
