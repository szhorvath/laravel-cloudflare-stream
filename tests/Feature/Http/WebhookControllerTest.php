<?php

declare(strict_types=1);

use function Pest\Laravel\postJson;

beforeEach(function () {
    config()->set('webhook-client.configs.0.signing_secret', 'a40a54471c07a225fc19ae4803d2e9a69aefac48');
});

it('should return 200', function () {
    $response = postJson(
        uri: '/webhook-cloudflare-stream',
        data: json_decode(
            json: fixture('webhook/stopped'),
            associative: true,
            flags: JSON_THROW_ON_ERROR,
        ),
        headers: [
            'Host' => 'host.docker.internal:7000',
            'User-Agent' => 'Cloudflare Stream Webhook',
            'Content-Length' => '1220',
            'Content-Type' => 'application/json',
            'webhook-signature' => 'time=1723646181,sig1=e2e3f20d0d4498270367caa4b7fdcf22db0ed1ec6d8be7e1add72c2c3241c04d',
            'webhook-signature-verification-instructions' => 'https://developers.cloudflare.com/stream/',
            'Accept-Encoding' => 'gzip',
            'x-forwarded-proto' => 'http',
            'x-expose-request-id' => '66bcc0e592e17',
            'upgrade-insecure-requests' => '1',
            'x-exposed-by' => 'Expose 2.4.0',
            'x-original-host' => 'yovdqwtdi0.laravel-sail.site:8080',
            'x-forwarded-host' => 'yovdqwtdi0.laravel-sail.site:8080',
        ]);

    $response->assertOk();
});
