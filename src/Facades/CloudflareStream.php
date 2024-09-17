<?php

namespace Szhorvath\LaravelCloudflareStream\Facades;

use GuzzleHttp\Psr7\Response as Psr7Response;
use Http\Mock\Client as MockClient;
use Illuminate\Support\Facades\Facade;
use Szhorvath\CloudflareStream\ClientBuilder;
use Szhorvath\CloudflareStream\Concerns\StreamSigner;
use Szhorvath\CloudflareStream\StreamSdk;
use Szhorvath\LaravelCloudflareStream\CloudflareStream as CfStream;

/**
 * @see \Szhorvath\CloudflareStream\StreamSdk
 *
 * @method static \Szhorvath\CloudflareStream\DataObjects\ApiResponse verifyToken()
 */
class CloudflareStream extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'cloudflare-stream';
    }

    /**
     * Register a stub callable that will intercept requests and be able to return stub responses.
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
            ),
            accountId: 'fake-account-id'
        );

        return static::swap($fake);
    }

    public static function response($body = null, $status = 200, $headers = [])
    {
        if (is_array($body)) {
            $body = json_encode($body);

            $headers['Content-Type'] = 'application/json';
        }

        return new Psr7Response($status, $headers, $body);
    }
}
